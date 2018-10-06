<?php

namespace App\Http\Controllers;
use Oseintow\Shopify\Facades\Shopify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ShopifyController extends Controller
{
	protected $shopUrl = "thc-store.myshopify.com";
	protected $scope = ["write_products","read_products"];
	protected $redirectUrl = "http://shopify.test/process-oauth-result";

	public function installShop()
	{
	    $shopify = Shopify::setShopUrl($this->shopUrl);
    	return $shopify->getAuthorizeUrl($this->scope,$this->redirectUrl);
	}

	public function getAccessToken(Request $request)
	{
	    $accessToken = Shopify::setShopUrl($this->shopUrl)->getAccessToken($request->code);
		return $accessToken;
	}

	public function getProducts()
	{
		$accessToken = Input::get('access_token');
		$products = (Shopify::setShopUrl($this->shopUrl)->setAccessToken($accessToken)->get("admin/products.json"))->toArray();
		
		$prods = [];
		$prod_type = [];
		foreach ($products as $key => $value) {
			$prods[] = [
				'id' => $value->id,
				'title' => $value->title,
				'prod_type' => $value->product_type,
				'price' => $value->variants[0]->price
			];

			if(!in_array($value->product_type, $prod_type))
			{
				$prod_type[] = $value->product_type;
			}
		}

		return view('dashboard', compact('prods','prod_type','accessToken'));
	}

	public function reloadTable(Request $request)
	{
		$accessToken = $request['access_token'];
		$products = (Shopify::setShopUrl($this->shopUrl)->setAccessToken($accessToken)->get("admin/products.json"))->toArray();
		
		$prods = [];
		$prod_type = [];
		foreach ($products as $key => $value) {
			$prods[] = [
				'id' => $value->id,
				'title' => $value->title,
				'prod_type' => $value->product_type,
				'price' => $value->variants[0]->price
			];

			if(!in_array($value->product_type, $prod_type))
			{
				$prod_type[] = $value->product_type;
			}
		}

		$data = [
			'products' => $prods,
			'type' => $prod_type
		];

		return response()->json($data);
	}

	public function filterProduct(Request $request)
	{
		$accessToken = $request['access_token'];
		$products = (Shopify::setShopUrl($this->shopUrl)->setAccessToken($accessToken)->get("admin/products.json"))->toArray();

		if(!empty($products))
		{
			$filter = $request['prod_type'];
			$prods = [];
			foreach ($products as $key => $value) {
				if($filter == $value->product_type)
				{
					$prods[] = [
						'id' => $value->id,
						'title' => $value->title,
						'prod_type' => $value->product_type,
						'price' => $value->variants[0]->price
					];
				}
			}
			if(!empty($prods))
			{
				return response()->json($prods);
			}
			else
			{
				return 'fail';
			}
		}
		else
		{
			return 'fail';
		}
	}

	public function addProduct(Request $request)
	{
		$accessToken = $request['access_token'];
		$data = $request['data'];

		$add = Shopify::setShopUrl($this->shopUrl)->setAccessToken($accessToken)->post("/admin/products.json", $data);
		
		if($add)
		{
			return 'success';
		}
		else
		{
			return 'fail';
		}
	}

	public function deleteProduct(Request $request)
	{
		$accessToken = $request['access_token'];
		$id = $request['id'];

		$delete = Shopify::setShopUrl($this->shopUrl)->setAccessToken($accessToken)->delete("/admin/products/".$id.".json");
		
		if($delete)
		{
			return 'success';
		}
		else
		{
			return 'fail';
		}
	}

	public function updateProduct(Request $request)
	{
		$accessToken = $request['access_token'];
		$id = $request['id'];
		$data = $request['data'];

		$update = Shopify::setShopUrl($this->shopUrl)->setAccessToken($accessToken)->put("/admin/products/".$id.".json", $data);
		dd($update);
		if($update)
		{
			return 'success';
		}
		else
		{
			return 'fail';
		}
	}
}
