<?php  $symbol = Session::get('symbol_right').''.Session::get('symbol_left'); ?>
<div class="keywords-slider my-2 cats">

    <div>
        <div class="category badge bg-white <?= ($result['active_category_id'] == 0) ? 'active' : '' ?> rounded p-2">
            <a href="javascript:;" data-ID="0" class="cat-filter"><?= App\Http\Controllers\Web\IndexController::trans_labels('All') ?></a>
        </div>
    </div>

    <?php foreach ($result['categories'] as $cat) : ?>
        <div>
            <div class="category badge bg-white <?= ($result['active_category_id'] == $cat['category_ID']) ? 'active' : '' ?> rounded p-2">
                <a href="javascript:;" data-ID="<?= $cat['category_ID'] ?>" class="cat-filter"><?= $cat['category_title'] ?></a>
            </div>
        </div>
    <?php endforeach; ?>

</div>


<?php if (!empty($result['products'])) : ?>

    <div class="prodsWrap">
        <div class="serach-head my-2 d-flex justify-content-between align-items-center">
            <strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Suggestions') ?> (<?= count($result['products']) ?>)</strong>
            <a href="javascript:;" class="link clear-search"><?= App\Http\Controllers\Web\IndexController::trans_labels('Clear') ?></a>
        </div>

        <?php foreach($result['products'] as $prod) : ?>

            <div class="p-2">
                <a href="<?= asset('product/'.$prod['prod_slug']) ?>" class="d-flex align-items-center gap-3 record-product" data-ID="<?= $prod['ID'] ?>">
                    <img src="<?= asset($prod['prod_image']) ?>" width="100">

                    <div>
                        <h5><?= $prod['prod_title'] ?></h5>

                        <?php
                            $prod_price = $prod['prod_price'] * session('currency_value');
                            $sale_price = $prod['sale_price'] * session('currency_value');
                        ?>

                        <?php if ($prod['prod_type'] == 'variable') : ?>
                            <?php if ($sale_price != null && $sale_price != $prod_price) : ?>
                                <i class="d-block">
                                    From <?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($sale_price, 2) ?>
                                    <del><?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?></del>
                                </i>
                            <?php else : ?>
                                <i class="d-block">
                                    From <?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?>
                                </i>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($sale_price != null && $sale_price != $prod_price) : ?>
                                <i class="d-block">
                                    <?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($sale_price, 2) ?>
                                    <del><?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?></del>
                                </i>
                            <?php else : ?>
                                <i class="d-block">
                                    <?= Session::get('symbol_right') ?> <?= Session::get('symbol_left') ?> <?= number_format($prod_price, 2) ?>
                                </i>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </a>
            </div>

        <?php endforeach; ?>
    </div>

<?php else : ?>

    <?php if ($result['keyword'] == '') : ?>

        <h4><?= App\Http\Controllers\Web\IndexController::trans_labels('Recent Searches') ?></h4>

        <div class="keywords d-flex flex-wrap py-2">

            <?php if (isset($result['recentproducts']) && count($result['recentproducts']) > 0) : ?>

                <?php foreach ($result['recentproducts'] as $prod) : ?>
                    <div class="badge bg-white rounded p-2 d-inline">
                        <a href="<?= asset('product/'.$prod['prod_slug']) ?>" class="record-product align-items-center d-flex gap-2" data-ID="<?= $prod['ID'] ?>" >
                            <svg width="17" xmlns="http://www.w3.org/2000/svg" width="20.816" height="18.086" viewBox="0 0 20.816 18.086"><path class="fill-current text-[#B6B6B6]" id="order-history-icon" d="M16317.121,21578.164a1,1,0,0,1,1.474-1.359,7.041,7.041,0,1,0-1.837-5.3l1.382-1.4a1,1,0,1,1,1.425,1.4l-2.925,2.969a1.02,1.02,0,0,1-.226.168l-.009.006-.029.016-.016.008a.2.2,0,0,0-.029.014l-.015.006a1,1,0,0,1-.983-.115l0,0s0,0-.006,0a1.013,1.013,0,0,1-.15-.139l-2.882-2.924a1,1,0,1,1,1.419-1.4l1.069,1.082a9.035,9.035,0,1,1,2.343,6.977Zm8.568-1.967-2.821-2.631a.992.992,0,0,1-.319-.732v-4.18a1,1,0,0,1,2,0v3.748l2.508,2.334a1,1,0,1,1-1.365,1.461Z" transform="translate(-16312.001 -21562.998)"></path></svg>
                            <?= $prod['prod_title'] ?>
                        </a>
                    </div>
                <?php endforeach; ?>

            <?php else : ?>

                <div class="border-0 py-2"><?= App\Http\Controllers\Web\IndexController::trans_labels('No Recent Searches') ?></div>

            <?php endif; ?>

        </div>

        <h4><?= App\Http\Controllers\Web\IndexController::trans_labels('Popular Searches') ?></h4>

        <div class="keywords-slider my-2 popular-search cats">

            <?php foreach ($result['popularproducts'] as $prod) : ?>

                <div>
                    <div class="popular-item badge bg-white border rounded p-2">
                        <a href="<?= asset('product/'.$prod['prod_slug']) ?>" class="record-product align-items-center d-flex gap-2" data-ID="<?= $prod['ID'] ?>" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16.239" height="12.883" viewBox="0 0 16.239 12.883"><path class="fill-current text-black" id="arrow-side-icon" d="M6885.866,21493.816a1,1,0,0,1-.367-1.369l3.22-5.578a1,1,0,0,1,1.37-.367l4.285,2.477,3.055-5.289-1.838.516a1,1,0,0,1-.539-1.932l4.143-1.15a1.006,1.006,0,0,1,1.295.7l1.084,4.223a1,1,0,0,1-.723,1.215,1,1,0,0,1-1.214-.719l-.475-1.85-3.555,6.154a1,1,0,0,1-1.365.367l-4.289-2.475-2.724,4.713a1,1,0,0,1-1.365.367Z" transform="translate(-6885.365 -21481.068)"></path></svg>
                            <?= $prod['prod_title'] ?>
                        </a>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php else : ?>

        <div class="prodsWrap">

            <div class="serach-head my-2 d-flex justify-content-between align-items-center">
                <strong><?= App\Http\Controllers\Web\IndexController::trans_labels('Suggestions') ?> (0)</strong>
                <a href="javascript:;" class="link clear-search"><?= App\Http\Controllers\Web\IndexController::trans_labels('Clear') ?></a>
            </div>

            <div class="p-2">
                <?= App\Http\Controllers\Web\IndexController::trans_labels('No Products Found Related To Query!') ?>
            </div>

        </div>

    <?php endif; ?>

<?php endif; ?>
