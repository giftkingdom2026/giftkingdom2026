<?php

$meta = $result['metadata'];

$addresses = isset($meta['address']) ? unserialize($meta['address']) : [];  

if(empty($addresses)) : ?>

    <div class="addressWrap d-flex flex-column gap-3 mt-5">

        <h6>No Saved Addresses!</h6>
    
    </div>

<?php else :?>

    <ul class="addressWrap d-flex flex-column gap-3 mt-5">

        <?php 

        $default = [];

        $key = 0;

        foreach($addresses as $index => $addr) : 

            $active = isset($addr['default']) ? 'active' : '';?>

            <li class="p-2 px-3 border rounded <?=$active?>">
                <a href="javascript:;" class="address-wrap change-addr" data-index="<?=$index?>">
                    <h6 class="mb-1"><?=$addr['label']?></h6>
                    <p><?=$addr['address']?></p>
                    <?php

                    $arr = str_split($addr['address']); ?>
                    <span style="display: none;"><?php foreach($arr as $key => $str) : echo $key < 27 ? $str : ''; endforeach?>...</span>
                </a>
            </li>

        <?php endforeach; ?>

    </ul>

    <?php endif;?>