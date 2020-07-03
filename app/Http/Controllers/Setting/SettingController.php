<?php

namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting\Setting;
use App\Models\APIError;
use App\Models\Setting\UserParish;


class SettingController extends Controller
{

    public function updateSetting (Request $request){
       
        $data = $request->only([
            'hour_payer',
            'angelus',
            'misericorde',
            'magnificat',
            'langue',
            'user_id',
            'parish_id'
        ]);

        $this->validate($data, [
            'hour_payer' => 'required',
            'angelus' => 'required',
            'misericorde' => 'required',
            'magnificat' => 'required',
            'langue' => 'required|min:2',
           // 'user_id' => 'integer|required|exists:App\Person\User,id'

        ]);
        //on met a jour les infos du user
        $setting = Setting::whereUserId($data['user_id'])->first();
        $setting->hour_payer=$data['hour_payer'];
        $setting->angelus=$data['angelus'];
        $setting->misericorde=$data['misericorde'];
        $setting->magnificat=$data['magnificat'];
        $setting->langue=$data['langue'];
        $setting->update();
        //on change la paroisse de utilisateur
        $userparishs = UserParish::join('user_utypes', ['user_utypes.user_utype_id' => 'user_parishs.user_utype_id'])
        ->where('user_utypes.user_id',$data['user_id']);
        foreach($userparishs as $up){
            $up->parish_id=$data['parish_id'];
            $up->update();
        }
        return response()->json($setting, 200);

    }


    public function delete($id){
        $setting = Setting::find($id);
        if($setting == null) {
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("SETTING_NOT_FOUND");
            $unauthorized->setMessage("setting id not found");

            return response()->json($unauthorized, 404);
        }
        $setting->delete($setting);
        return response(null);
    }


    public function get(Request $req){
        $s = $req->s;
        $page = $req->page;
        $limit = null;

        if ($req->limit && $req->limit > 0) {
            $limit = $req->limit;
        }

        if ($s) {
            if ($limit || $page) {
                $settings = Setting::where('subject', 'LIKE', '%' . $s . '%')->orWhere('message', 'LIKE', '%' . $s . '%')->paginate($limit);
            } else {
                $settings = Setting::where('subject', 'LIKE', '%' . $s . '%')->orWhere('message', 'LIKE', '%' . $s . '%')->get();
            }
        } else {
            if ($limit || $page) {
                $settings = Setting::paginate($limit);
            } else {
                $settings = Setting::all();
            }
        }

        return response()->json($settings);
    }

    public function find($id){
        $setting = Setting::find($id);
        if($setting == null) {
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("SETTINGS_NOT_FOUND");
            $unauthorized->setMessage("settings id not found");

            return response()->json($unauthorized, 404);
        }
        return response()->json($setting);
    }

    public function update(Request $request, $id){
        $request->validate([
            'key' => 'required'
        ]);

        $data = $request->only([
            'key',
            'value',
            'description'
        ]);
        
        $setting = Setting::find($id);
        if($setting == null) {
            $unauthorized = new APIError;
            $unauthorized->setStatus("404");
            $unauthorized->setCode("SETTING_NOT_FOUND");
            $unauthorized->setMessage("setting id not found");

            return response()->json($unauthorized, 404);
        }

        if($request->key != $setting->key){
            $setting_already_existing = Setting::whereKey($request->key);
            if($request->key == $setting_already_existing){
                $unauthorized = new APIError;
                $unauthorized->setStatus("400");
                $unauthorized->setCode("SETTING_ALREADY_IN_db");
                $unauthorized->setMessage("setting already existing");
    
                return response()->json($unauthorized, 404);
    
            }
        }
        $setting->update($data);
        return response()->json($setting);
    }
}

