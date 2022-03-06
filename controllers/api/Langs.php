<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use DB;
use Illuminate\Http\JsonResponse;
use Kharanenka\Helper\Result;
use PlanetaDelEste\ApiShopaholic\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Locale;
use RainLab\Translate\Models\Message;

class Langs extends Base
{
    /** @var Translator */
    protected $obTranslator;

    /**
     * Switch to language and return translations
     *
     * @param string|null $lang
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lang(string $lang = null): JsonResponse
    {
        try {
            if (!$lang || !Locale::isValid($lang)) {
                $lang = Locale::getDefault()->code;
            }

            $isLocaleChanged = $lang !== $this->obTranslator->getLocale();
            if ($isLocaleChanged) {
                $this->fireSystemEvent(Plugin::EVENT_LOCALE_BEFORE_CHANGE, [$lang], false);
            }

            $this->obTranslator->setLocale($lang);
            $sLocale = $lang;

            if ($isLocaleChanged) {
                $this->fireSystemEvent(Plugin::EVENT_LOCALE_AFTER_CHANGE, [$lang], false);
            }

            if (config('database.default') === 'pgsql') {
                $messages = Message::whereRaw("message_data::json->>'{$sLocale}' <> ''")
                    ->select(
                        [
                            'code',
                            DB::raw("message_data::json->>'{$sLocale}' as message")
                        ]
                    )
                    ->lists('message', 'code');
            } else {
                $messages = Message::whereRaw("JSON_EXTRACT(`message_data`, '$.{$sLocale}') <> \"\"")
                    ->select(
                        [
                            'code',
                            DB::raw("JSON_UNQUOTE(JSON_EXTRACT(`message_data`, '$.{$sLocale}')) as `message`")
                        ]
                    )
                    ->lists('message', 'code');
            }


            return response()->json(compact('messages'));
        } catch (\Exception $ex) {
            return self::exceptionResult($ex);
        }
    }

    /**
     * Return a list of enabled languages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function langs(): JsonResponse
    {
        try {
            $arLangs = Locale::listEnabled();
            Result::setTrue()->setData($arLangs);

            return response()->json(Result::get());
        } catch (\Exception $ex) {
            return self::exceptionResult($ex);
        }
    }

    /**
     * Return current locale
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function locale(): JsonResponse
    {
        try {
            Result::setTrue()->setData($this->obTranslator->getLocale());

            return response()->json(Result::get());
        } catch (\Exception $ex) {
            return self::exceptionResult($ex);
        }
    }

    /**
     * Store for missing translations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function missing(): JsonResponse
    {
        $data = input();

        if ($lang = array_get($data, 'lang')) {
            if ($lang !== $this->obTranslator->getLocale()) {
                $this->obTranslator->setLocale($lang);
            }
        }

        $message = static::tr(array_get($data, 'message'), [], $lang);
        return response()->json(compact('message'));
    }

    /**
     * @return void
     */
    public function init(): void
    {
        $this->obTranslator = Translator::instance();
    }
}
