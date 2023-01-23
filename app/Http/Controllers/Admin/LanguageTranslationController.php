<?php


namespace App\Http\Controllers\Admin;

use DB;
use File;
use Exception;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\Language\StoreLanguageRequest;

class LanguageTranslationController extends Controller
{
    public function createLanguage()
    {
        return view('admin.language.addLanguage');
    }

    public function addLanguage(StoreLanguageRequest $request)
    {
        try {
            $language = Language::create($request->all());
            if ($language) {
                $new_lang = Language::all()->pluck('name', 'code')->toArray();
                $fp = fopen(base_path('config/languages.php'), 'w');
                fwrite($fp, '<?php return ' . var_export($new_lang, true) . ';');
                Artisan::call('config:clear');
                fclose($fp);
                return redirect()->route('languages');
            } else {
                return back()->withError('Something Went Wrong');
            }
        } catch (Exception $ex) {
            return back()->withError($ex->getMessage());
        }
    }

    public function index()
    {
        $languages = DB::table('languages')->get();
        $columns = [];
        $columnsCount = $languages->count();
        if ($languages->count() > 0) {
            foreach ($languages as $key => $language) {
                if ($key == 0) {
                    $columns[$key] = $this->openJSONFile($language->code);
                }
                $columns[++$key] = ['data' => $this->openJSONFile($language->code), 'lang' => $language->code];
            }
        }
        return view('admin.language.languages', compact('languages', 'columns', 'columnsCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);
        $data = $this->openJSONFile('en');
        $data[$request->key] = $request->value;
        $this->saveJSONFile('en', $data);
        return redirect()->route('languages');
    }
    public function destroy($key)
    {
        $languages = DB::table('languages')->get();
        if ($languages->count() > 0) {
            foreach ($languages as $language) {
                $data = $this->openJSONFile($language->code);
                unset($data[$key]);
                $this->saveJSONFile($language->code, $data);
            }
        }
        return redirect()->route('languages');
    }

    private function openJSONFile($code)
    {
        $jsonString = [];
        if (File::exists(base_path('lang/' . $code . '.json'))) {
            $jsonString = file_get_contents(base_path('lang/' . $code . '.json'));
            $jsonString = json_decode($jsonString, true);
        }
        return $jsonString;
    }

    private function saveJSONFile($code, $data)
    {
        ksort($data);
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents(base_path('lang/' . $code . '.json'), stripslashes($jsonData));
    }


    public function transUpdate(Request $request)
    {
        $data = $this->openJSONFile($request->code);
        $data[$request->pk] = $request->value;
        $this->saveJSONFile($request->code, $data);
        return response()->json(['success' => 'Done!']);
    }


    public function transUpdateKey(Request $request)
    {
        $languages = DB::table('languages')->get();
        if ($languages->count() > 0) {
            foreach ($languages as $language) {
                $data = $this->openJSONFile($language->code);
                if (isset($data[$request->pk])) {
                    $data[$request->value] = $data[$request->pk];
                    unset($data[$request->pk]);
                    $this->saveJSONFile($language->code, $data);
                }
            }
        }
        return response()->json(['success' => 'Done!']);
    }


    public function deleteLanguage(Language $language)
    {
        try {
            $language->delete();
            $new = Language::all()->pluck('name', 'code')->toArray();
            $fp = fopen(base_path('config/languages.php'), 'w');
            fwrite($fp, '<?php return ' . var_export($new, true) . ';');
            fclose($fp);
            Artisan::call('config:clear');
            return redirect()->route('languages');
        } catch (Exception $ex) {
            return back()->withError($ex->getMessage());
        }
    }
    public function newlyConfig()
    {
        $mArr = Language::all()->pluck('name', 'code')->toArray();
        $cArr = Config::get('languages') ?? [];

        if (!$cArr){
            $fp = fopen(base_path('config/languages.php'), 'w+');
            fwrite($fp, '<?php return ' . var_export($mArr, true) . ';');
            fclose($fp);
        }

        Artisan::call('config:clear');
        $new_array = array_diff($cArr, $mArr);
        $old_array = array_diff($mArr, $cArr);
        if (count($new_array) > 0 || count($old_array) > 0) {
            foreach ($new_array as $key => $value) {
                Language::create(['name' => $value, 'code' => $key]);
            };
            Language::whereIn('name', $old_array)->delete();
            return Redirect()->route('languages')->with('success', 'Sync Successfully');
        } else {
            return back()->with('error', 'Nothing To Sync');
        }
    }
}
