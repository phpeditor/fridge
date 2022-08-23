<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Orders;
use App\Models\OrdersBlock;
class AppController extends Controller
{
    public function BookBlocks(Request $request)
    {
        $data['user'] = $request->get('user');
        $data['location_id'] = intval($request->get('location_id'));
        $data['volume'] = (float)$request->get('volume');
        $data['temperature'] = intval($request->get('temperature'));
        $data['date_from'] = $request->get('date_from');
        $data['date_to'] = $request->get('date_to');
        $data['total'] = (float)$request->get('total');
        $blocks = $request->get('blocks');
        $error = false;
        $json = array();
        if(!$data['user'])
        {
            $json['errors'][] = 'Error Username';
            $error = true;
        }
        if(!$data['location_id'])
        {
            $json['errors'][] = 'Error Location';
            $error = true;
        }
        if($data['volume']<=0)
        {
            $json['errors'][] = 'Error Volume';
            $error = true;
        }
        if($data['temperature']<0)
        {
            $json['errors'][] = 'Error Temperature';
            $error = true;
        }
        if(!$data['date_from'])
        {
            $json['errors'][] = 'Error Date From';
            $error = true;
        }
        if(!$data['date_to'])
        {
            $json['errors'][] = 'Error Date To';
            $error = true;
        }
        if(!$data['total'])
        {
            $json['errors'][] = 'Error Total';
            $error = true;
        }
        if(!$blocks)
        {
            $json['errors'][] = 'Error Blocks';
            $error = true;
        }
        if(!$error)
        {
            $data['code'] = Str::random(12);
            $dataOrder = new Orders;
            $dataOrder->user = $data['user'];
            $dataOrder->location_id = $data['location_id'];
            $dataOrder->volume = $data['volume'];
            $dataOrder->temperature = $data['temperature'];
            $dataOrder->date_from = date('Y-m-d H:i:s', strtotime($data['date_from']));
            $dataOrder->date_to = date('Y-m-d H:i:s', strtotime($data['date_to']));
            $dataOrder->total = $data['total'];
            $dataOrder->code = $data['code'];
            $dataOrder->save();
            $order_id = $dataOrder->id;
            foreach($blocks as $block_id)
            {
                $dataOrderBlock = new OrdersBlock;
                $dataOrderBlock->block_id = $block_id;
                $dataOrderBlock->order_id = $order_id;
                $dataOrderBlock->save();
            }
            $json['success'][] = 'Your order#'.$order_id.' with code '.$data['code'].' success created!';
        }
        return response(json_encode($json), 200)->header('Content-Type', 'application/json');
    }
}
