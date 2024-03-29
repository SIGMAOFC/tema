<?php

namespace App\Classes\Settings;

use App\Classes\Pterodactyl;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Qirolab\Theme\Theme;

class Information
{
    public function __construct()
    {
    }

    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alert-enabled' => 'string',
            'alter-type' => 'string',
            'alert-message' => 'string|nullable',
            'motd-enabled' => 'string',
            'usefullinks-enabled' => 'string',
            'motd-message' => 'string|nullable',
            'show-imprint' => 'string',
            'show-privacy' => 'string',
            'show-tos' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.settings.index') . '#motd-&-alert')
                ->with('error', __('Motd & Alert settings have not been updated!'))
                ->withErrors($validator)
                ->withInput();
        }

        $values = [
            'SETTINGS::SYSTEM:ALERT_ENABLED' => 'alert-enabled',
            'SETTINGS::SYSTEM:ALERT_TYPE' => 'alert-type',
            'SETTINGS::SYSTEM:ALERT_MESSAGE' => 'alert-message',
            'SETTINGS::SYSTEM:MOTD_ENABLED' => 'motd-enabled',
            'SETTINGS::SYSTEM:MOTD_MESSAGE' => 'motd-message',
            'SETTINGS::SYSTEM:USEFULLINKS_ENABLED' => 'usefullinks-enabled',
            'SETTINGS::SYSTEM:SHOW_IMPRINT' => 'show-imprint',
            'SETTINGS::SYSTEM:SHOW_PRIVACY' => 'show-privacy',
            'SETTINGS::SYSTEM:SHOW_TOS' => 'show-tos',
        ];

        foreach ($values as $key => $value) {
            $param = $request->get($value);

            Settings::where('key', $key)->updateOrCreate(['key' => $key], ['value' => $param]);
            Cache::forget('setting' . ':' . $key);
        }

        return redirect(route('admin.settings.index') . '#motd-&-alert')->with('success', __('Motd & Alert settings updated!'));
    }
}
