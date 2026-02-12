<div class="row gy-lg-5" id="results">
    <?php
    if (!empty($data['stores'])) :
        foreach ($data['stores'] as $store) : ?>
            <div class="col-sm-6 wrap col-lg-3">
                <div class="product-card overflow-hidden">
                    <figure class="d-flex justify-content-center align-items-center position-relative overflow-hidden">
                        <a href="<?= asset('store/' . $store['metadata']['store_name']) ?>">
                            <img src="<?= asset($store['metadata']['store_logo_image']) ?>" alt="*">
                        </a>
                        <div class="position-absolute bottom-0 left-0 right-0 w-100 shop-now px-3 py-2">
                            <a href="<?= asset('store/' . $store['metadata']['store_name']) ?>"
                                class="d-flex align-items-center gap-3 justify-content-between text-white">
                                <?= App\Http\Controllers\Web\IndexController::trans_labels('Visit Now') ?>
                            </a>
                        </div>
                    </figure>
                    <article class="text-center pt-3 wow fadeInUp">
                        <h4 title="<?= $store['metadata']['store_name'] ?>"><?= $store['metadata']['store_name'] ?></h4>
                        <h6 class="mb-3 wow fadeInUp">(<?= $store['metadata']['vendor_name'] ?>)</h6>
                    </article>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if ($result['total'] > $result['per_page']) : ?>
            <div class="col-md-12">
                <div class="new_links">
                    <div class="pagination d-flex justify-content-center align-items-center gap-4 mt-5">
                        <ul class="d-flex justify-content-center align-items-center gap-4">
                            <?php foreach ($result['links'] as $link) :
                                $url = $link['url'] ? $link['url'] : 'javascript:;';
                                $class = $link['active'] ? 'active' : '';
                                $title = $link['label'];
                                str_contains($link['label'], 'Previous') ?
                                    $title = '<svg width="12" height="12" ...></svg>' : '';
                                str_contains($link['label'], 'Next') ?
                                    $title = '<svg width="12" height="12" ...></svg>' : '';
                            ?>
                                <li>
                                    <a href="<?= $url ?>" class="<?= $class ?> page-link-products"><?= $title ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <h3 class="text-center py-5"><?= App\Http\Controllers\Web\IndexController::trans_labels('No Stores Found') ?></h3>
    <?php endif; ?>
</div>
