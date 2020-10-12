<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Array_;

class Balance extends Model
{
    const INPUT = 'I';
    const OUTPUT = 'O';

    public $timestamps = false;

    public function deposit(float $value) : Array
    {
        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount += number_format($value, 2, '.', '');
        $deposit = $this->save();

        $historic= auth()->user()->historics()->create([
            'type'          => self::INPUT,
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Y-m-d'),
        ]);
        
        if ($deposit && $historic) {
            DB::commit();
            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar',
            ];
        } else {
            DB::rollback();
            return [
                'error' => false,
                'message' => 'Falha ao carregar',
            ];
        }
    }

    public function withDraw(float $value) : Array
    {
        if ($this->amount < $value)
            return [
                'success' => false,
                'message' => 'Saldo insuficiênte'
            ];

        DB::beginTransaction();

        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $withdrawn = $this->save();

        $historic = auth()->user()->historics()->create([
            'type'          => self::OUTPUT,
            'amount'        => $value,
            'total_before'  => $totalBefore,
            'total_after'   => $this->amount,
            'date'          => date('Y-m-d'),
        ]);

        if ($withdrawn && $historic) {
            DB::commit();

            return [
                'success' => true,
                'message' => 'Successo ao retirar',
            ];
        } else {
            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao retirar',
            ];
        }
    }

    public function transfer(float $value, User $sender): Array
    {
        if ($this->amount < $value)
            return [
                'success' => false,
                'message' => 'Saldo insuficiênte'
            ];

        DB::beginTransaction();
        
        $totalBefore = $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', '');
        $transfer = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'T',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' => $this->amount,
            'date' => date('Y-m-d'),
            'user_id_transaction' => $sender->id,
        ]);
        

        $senderBalance = $sender->balance()->firstOrCreate([]);
        $totalBeforeSender = $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.', '');
        $transferSender = $senderBalance->save();

        $historicSender = $sender->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $totalBeforeSender,
            'total_after' => $senderBalance->amount,
            'date' => date('Y-m-d'),
            'user_id_transaction' => auth()->user()->id,
        ]);

        if ($transfer && $historic && $transferSender && $historicSender) {
            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao Transferir',
            ];
        }

        DB::rollback();

        return [
            'success' => false,
            'message' => 'Falha ao Retirar',
        ];

    }

}
