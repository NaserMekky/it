<?php
namespace Phpanonymous\It\Controllers\Baboon\Api;

use App\Http\Controllers\Controller;

class BaboonCreateApi extends Controller {

	public static function indexMethod($r) {
		$index = '
            /**
             * Baboon Api Script By ' . it_version_message() . '
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	${ModelName} = {ModelName}::select($this->selectColumns)->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>${ModelName}]);
            }' . "\n";

		return str_replace('{ModelName}', request('model_name'), $index);
	}

	public static function storeMethod($r) {
		$objectlist = [];
		$store = '
            /**
             * Baboon Api Script By ' . it_version_message() . '
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(' . request('controller_name') . 'Request $request)
    {
    	$data = $request->except("_token");
    	' . "\n";

		if ($r->has('has_user_id')) {
			$store .= '              $data["user_id"] = auth()->id(); ' . "\n";
		}

		$i = 0;
		foreach (request('col_name_convention') as $conv) {
			$objectlist = [];
			if (checkIfExisitValue('api_show_column', $conv)) {
				if (request('col_type')[$i] == 'file') {
					$store .= '                $data["' . $conv . '"] = "";' . "\n";
				}
			}
			$i++;
		}

		$store .= '        ${ModelName} = {ModelName}::create($data); ' . "\n";

		$x = 0;
		foreach (request('col_name_convention') as $conv) {
			$objectlist = [];
			if (checkIfExisitValue('api_show_column', $conv)) {
				if (request('col_type')[$x] == 'file') {
					$store .= '               if(request()->hasFile("' . $conv . '")){' . "\n";
					$folder = str_replace('controller', '', strtolower(request('controller_name')));

					$store .= '              ${ModelName}->' . $conv . ' = it()->upload("' . $conv . '","' . $folder . '/".${ModelName}->id);' . "\n";
					$store .= '              ${ModelName}->save();' . "\n";
					$store .= '              }' . "\n";
				}
			}
			$x++;
		}

		$store .= '
        return successResponseJson([
            "message"=>trans("{lang}.added"),
            "data"=>${ModelName}
        ]);
    }';
		$store = str_replace('{ModelName}', request('model_name'), $store);
		$store = str_replace('{lang}', request('lang_file'), $store);

		return $store;
	}

}
