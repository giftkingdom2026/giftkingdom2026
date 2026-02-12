<?php

$meta = $data['metadata'];

$addresses = isset($meta['address']) ? unserialize($meta['address']) : []; 

foreach($addresses as $key => $addr) : ?>

	@include('web.account.address-form',['data' => $addr, 'key' => $key])

<?php endforeach;?>

