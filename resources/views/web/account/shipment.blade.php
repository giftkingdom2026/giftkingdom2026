
<div class="row shipment-data">

    <div class="col-md-12">

        <div class="steps-vertical ">

            <?php

            if( date('H', strtotime($order['created_at']) ) < 3 ) : 

                $success = date('d M, Y', strtotime($order['created_at']. ' + 3 days'));

            else :

                $success = date('d M, Y', strtotime($order['created_at']. ' + 4 days'));

            endif;

            $arr = [ 
                "Placed" => ['text' => ['Placed'], 'date' => $order['created_at']],
                "Packed" => ['text' => ['Allotted For Pickup']],
                "Dispatched" => ['text' => ['Package Picked Up','Package Picked Up']],
                "Out for Delivery" => ['text' => ['On The Way To Delivery']],
                "Delivered By" => ['text' => ['Delivered Success'],'date' => $success]
            ]; 

            foreach( $history as $item1 ) :

                foreach($arr as &$item2) :

                    in_array($item1['shipment_status'], $item2['text']) ? $item2['date'] = $item1['created_at'] : '';

                endforeach;

            endforeach;

    // $arr2 = ["Delivery Failed", "Returned To Store"];

            $c = !empty($data) ? 'active-step' : '';

            foreach($arr as $key => $item) :  ?>

                <div class="step <?=$c?>">
                    <div class="step-info">
                        <div class="step-label d-flex flex-row gap-2"><?=$key?> <?=isset($item['date']) ? '<span>on '.date('d M',strtotime($item['date'])).'</span>' : '';?></div>
                    </div>
                    <div class="step-content"></div>
                </div>

                <?php 

                isset($data->shipment_status) && in_array($data->shipment_status,$item['text']) ? $c = '' : '';

            endforeach;?>

        </div>

    </div>
    <div class="col-md-12">

        <a href="javascript:;" class="btn toggle-text mb-3">Reschedule</a>

        <p style="display: none;" class="msg_alert alert alert-success">To reschedule the delivery, please contact our team at <a href="mailto:sales@gift-kingdom.com" class="link">sales@gift-kingdom.com</a></p>

    </div>

</div>
