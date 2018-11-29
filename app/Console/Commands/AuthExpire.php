<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Device;

class AuthExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for expired authentication codes and set the auth state to expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expire_id_array = [];
        $expired_auths = [];
        $auths_pending = \DB::select('SELECT * FROM devices WHERE status = 0');

        foreach($auths_pending as $auth){
            array_push($expired_auths,$auth);
        }

        foreach($expired_auths as $single_auth){
            if($this->isExpire($single_auth->created_at,$single_auth->expires)){
                array_push($expire_id_array,$single_auth->id);
            }
        }

        $updated_at = date("Y-m-d H:i:s");
        
        $device = Device::whereIn('id', $expire_id_array);
            $device->update([
                'updated_at' => $updated_at,
                'status' => 3
        ]);

    }

    public function isExpire($time_created, $seconds_valid)
    {
        $date = date_create("$time_created");
        date_add($date, date_interval_create_from_date_string("$seconds_valid second"));
        $time_to_expire_string  = date_format($date, 'Y-m-d H:i:s');

        $time_to_expire = date_create(date("$time_to_expire_string"));
        $present_time = date_create(date("Y-m-d H:i:s"));
        $diff = date_diff($time_to_expire,$present_time);
        
        $minutes = floor($seconds_valid / 60);

        if($diff->y > 0){
            return true;
        }else if($diff->m > 0){
            return true;
        }else if($diff->d > 0){
            return true;
        }else if($diff->h > 0){
            return true;
        }else if($diff->i > $minutes){
            return true;
        }

        return false;
    }
}
