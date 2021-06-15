<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use DB;
use Illuminate\Http\JsonResponse;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Message;

class Langs extends Base
{
    public function lang($lang): JsonResponse
    {
        $locale = Translator::instance();
        $locale->setLocale($lang);

        if (config('database.default') == 'pgsql') {
            $messages = Message::whereRaw("message_data::json->>'{$locale->getLocale()}' <> ''")
                ->select(
                    [
                        'code',
                        DB::raw("message_data::json->>'{$locale->getLocale()}' as message")
                    ]
                )
                ->lists('message', 'code');
        } else {
            $messages = Message::whereRaw("JSON_EXTRACT(`message_data`, '$.{$locale->getLocale()}') <> \"\"")
                ->select(
                    [
                        'code',
                        DB::raw("JSON_UNQUOTE(JSON_EXTRACT(`message_data`, '$.{$locale->getLocale()}')) as `message`")
                    ]
                )
                ->lists('message', 'code');
        }


        return response()->json(compact('messages'));
    }

    public function missing(): JsonResponse
    {
        $data = input();

        if ($lang = array_get($data, 'lang')) {
            $locale = Translator::instance();
            if ($lang != $locale->getLocale()) {
                $locale->setLocale($lang);
            }
        }

        $message = static::tr(array_get($data, 'message'), [], $lang);
        return response()->json(compact('message'));
    }
}
