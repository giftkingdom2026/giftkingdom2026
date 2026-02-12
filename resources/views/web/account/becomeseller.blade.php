@extends('web.layout')



@section('content')
    <div class="breadcrumb">

        <div class="container">

            <ul class="d-flex align-items-center gap-2">

                <li><a href="javascript:;">Home</a></li>

                <li>></li>

                <li><a href="javascript:;">Account</a></li>

            </ul>

        </div>

    </div>



    <section class="main-section account-section">

        <div class="container">

            <div class="row">

                <div class="col-md-4 col-lg-3">

                    @include('web.account.sidebar')

                </div>

                <?php
                
                $meta = $result['metadata']; ?>

                <div class="col-md-8 col-lg-9">

                    <div class="acc-right">

                        <form class="careerFilter" action="<?= asset('/vendor/update') ?>" method="POST"
                            enctype='multipart/form-data'>

                            @csrf

                            <div class="main-heading mb-4 mt-4">

                                <h2>Vendor Info</h2>

                            </div>

                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            <div class="row">

                                {{-- <div class="col-md-6 col-lg-4">

                                    <div class="form-group clear-text">

                                        <label class="mb-2">Vendor Name</label>

                                        <?php $vendorname = isset($meta['vendor_name']) ? $meta['vendor_name'] : ''; ?>

                                        <input type="text" name="meta[vendor_name]" value="<?= $vendorname ?>" required
                                            placeholder="Vendor Name" class="form-control">

                                    </div>

                                </div> --}}

                                <div class="col-md-6 col-lg-6">

                                    <div class="form-group">

                                        <label class="mb-2 d-flex align-items-center justify-content-between">Email Address
                                            <a class="edit-email" href="javascript:;">Edit</a></label>

                                        <?php $vendoremail = isset($meta['vendor_email']) ? $meta['vendor_email'] : ''; ?>

                                        <input type="email" name="meta[vendor_email]" readonly required
                                            value="<?= $vendoremail ?>" placeholder="vendor@store.com" class="form-control">

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-6">

                                    <div class="form-group">

                                        <label class="mb-2 d-flex align-items-center justify-content-between">Mobile

                                            <!-- <a href="javascript:;" class="addphone">Add</a> -->

                                        </label>

                                        <?php $vendorphone = isset($meta['vendor_phone']) ? $meta['vendor_phone'] : ''; ?>

                                        <div class="phone-wrapper">

                                            <input type="number" name="meta[vendor_phone]" required
                                                value="<?= $vendorphone ?>" placeholder="Enter your number"
                                                class="form-control">

                                            <div class="invalid"><svg width="20" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path fill="#ff0000"
                                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                                                </svg></div>
                                            <div class="valid"><svg width="20" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path fill="#04ff00"
                                                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
                                                </svg></div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="main-heading mb-4 mt-4">
                                <h2>Store</h2>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group clear-text">
                                        <label class="mb-2">Name</label>

                                        <?php $storename = isset($meta['store_name']) ? $meta['store_name'] : ''; ?>

                                        <input type="text" name="meta[store_name]" required value="<?= $storename ?>"
                                            placeholder="Store Name" class="form-control">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group clear-text">
                                        <label class="mb-2">Address</label>

                                        <?php $address = isset($meta['vendor_address']) ? $meta['vendor_address'] : ''; ?>

                                        <input type="text" name="meta[vendor_address]" required value="<?= $address ?>"
                                            placeholder="Address" class="form-control">

                                    </div>
                                </div>

                            </div>

                            <div class="row align-items-center">

                                <div class="col-md-6 col-lg-6 mt-3">
                                    <div class="form-group clear-text">
                                        <label class="mb-2 d-block">Logo Image</label>

                                        <?php
                                        $storelogo = isset($meta['store_logo_image']) ? $meta['store_logo_image'] : '';
                                        $attr = 'required';
                                        ?>

                                        <?php if ($storelogo != '') : $attr = ''; ?>

                                        <img style="height: 150px;object-fit: contain; width: 100%;"
                                            src="<?= asset($storelogo) ?>">

                                        <?php endif; ?>

                                        <input type="file" name="meta[files][store_logo_image]" <?= $attr ?>
                                            value="" placeholder="Store Image" class="form-control"
                                            accept=".png, .jpg, .jpeg, .svg">
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 mt-3">
                                    <div class="form-group clear-text">
                                        <label class="mb-2 d-block">Featured Image</label>

                                        <?php
                                        $featuredImage = isset($meta['featured_image']) ? $meta['featured_image'] : '';
                                        $attr = 'required';
                                        ?>

                                        <?php if ($featuredImage != '') : $attr = ''; ?>

                                        <img style="height: 150px;object-fit: contain; width: 100%;"
                                            src="<?= asset($featuredImage) ?>">

                                        <?php endif; ?>

                                        <input type="file" name="meta[files][featured_image]" <?= $attr ?> value=""
                                            placeholder="Store Image" class="form-control" accept=".png, .jpg, .jpeg, .svg">
                                    </div>
                                </div>

                            </div>

                            <div class="main-heading mb-4 mt-4">
                                <h2>Vendor Documents</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group clear-text">
                                        <label class="mb-3 d-block">Trade License or Commercial Registration</label>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php
                                            $license_registration = isset($meta['license_registration']) ? $meta['license_registration'] : '';
                                            $attr = 'required';
                                            ?>

                                            <?php if ($license_registration != '') :
                $attr = '';
                $fileUrl = asset($license_registration);
            ?>

                                            <?php if ($fileUrl && !str_contains($fileUrl, '.pdf')) : ?>
                                            <img class="doc_img" src="<?= $fileUrl ?>" alt="Trade License">
                                            <?php endif; ?>

                                            <?php endif; ?>
                                        </div>

                                        <input type="file" name="meta[files][license_registration]" <?= $attr ?>
                                            accept="image/jpeg,image/png,image/jpg,application/pdf" class="form-control">
                                    </div>

                                    <?php if ($license_registration != '' && str_contains($fileUrl, '.pdf')) : ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" class="mt-3 mb-3 link">
                                        View
                                    </a>
                                    <?php endif; ?>
                                </div>


                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group clear-text">
                                        <label class="mb-3 d-block">VAT Registration Certificate</label>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php
                                            $vat_registration = isset($meta['vat_registration']) ? $meta['vat_registration'] : '';
                                            $attr = 'required';
                                            ?>

                                            <?php if ($vat_registration != '') :
                $attr = '';
                $fileUrl = asset($vat_registration);
            ?>

                                            <?php if ($fileUrl && !str_contains($fileUrl, '.pdf')) : ?>
                                            <img class="doc_img" src="<?= $fileUrl ?>" alt="VAT Registration">
                                            <?php endif; ?>

                                            <?php endif; ?>
                                        </div>

                                        <input type="file" name="meta[files][vat_registration]" <?= $attr ?>
                                            accept="image/jpeg,image/png,image/jpg,application/pdf" class="form-control">
                                    </div>

                                    <?php if ($vat_registration != '' && str_contains($fileUrl, '.pdf')) : ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" class="mt-3 mb-3 link">
                                        View
                                    </a>
                                    <?php endif; ?>
                                </div>


                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group clear-text">
                                        <label class="mb-3 d-block">Residence ID of the Legal Signatory</label>

                                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
                                            <?php
                                            $residence_id = isset($meta['residence_id']) ? $meta['residence_id'] : '';
                                            $attr = 'required';
                                            ?>

                                            <?php if ($residence_id != '') :
                $attr = '';
                foreach ($residence_id as $val) :
                    $fileUrl = asset($val);
            ?>

                                            <?php if (!str_contains($fileUrl, '.pdf')) : ?>
                                            <img class="doc_img" src="<?= $fileUrl ?>" alt="Residence ID">
                                            <?php endif; ?>

                                            <?php endforeach; endif; ?>
                                        </div>

                                        <input type="file" name="meta[files][residence_id][]" multiple <?= $attr ?>
                                            accept="image/jpeg,image/png,image/jpg,application/pdf" class="form-control">
                                    </div>

                                    <?php if ($residence_id != '') :
        foreach ($residence_id as $val) :
            $fileUrl = asset($val);
            if (str_contains($fileUrl, '.pdf')) :
    ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" class="mt-3 mb-3 link d-inline-block me-2">
                                        View
                                    </a>
                                    <?php endif; endforeach; endif; ?>
                                </div>


                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group clear-text">
                                        <label class="mb-3 mt-3 d-block">Residence Visa</label>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php
                                            $residence_visa = isset($meta['residence_visa']) ? $meta['residence_visa'] : '';
                                            $attr = 'required';
                                            ?>

                                            <?php if ($residence_visa != '') :
                $attr = '';
                $fileUrl = asset($residence_visa);
            ?>

                                            <?php if (!str_contains($fileUrl, '.pdf')) : ?>
                                            <img class="doc_img" src="<?= $fileUrl ?>" alt="Residence Visa">
                                            <?php endif; ?>

                                            <?php endif; ?>
                                        </div>

                                        <input type="file" name="meta[files][residence_visa]" <?= $attr ?>
                                            accept="image/jpeg,image/png,image/jpg,application/pdf" class="form-control">
                                    </div>

                                    <?php if ($residence_visa != '' && str_contains($fileUrl, '.pdf')) : ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" class="mt-3 mb-3 link">
                                        View
                                    </a>
                                    <?php endif; ?>
                                </div>


                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group clear-text">
                                        <label class="mb-3 mt-3 d-block">Bank Account Confirmation Letter</label>

                                        <div class="d-flex align-items-center justify-content-center">
                                            <?php
                                            $bank_confirmation = isset($meta['bank_confirmation']) ? $meta['bank_confirmation'] : '';
                                            $attr = 'required';
                                            ?>

                                            <?php if ($bank_confirmation != '') : 
                $attr = ''; 
                $fileUrl = asset($bank_confirmation);
            ?>

                                            <?php if (!str_contains($fileUrl, '.pdf')) : ?>
                                            <img class="doc_img" src="<?= $fileUrl ?>" alt="Bank Confirmation">
                                            <?php endif; ?>

                                            <?php endif; ?>
                                        </div>

                                        <input type="file" name="meta[files][bank_confirmation]" <?= $attr ?>
                                            accept="image/jpeg,image/png,image/jpg,application/pdf" class="form-control">
                                    </div>
                                    <?php if (isset($fileUrl) && str_contains($fileUrl, '.pdf')) : ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" class="mt-3 mb-3 link">
                                        View
                                    </a>
                                    <?php endif; ?>
                                </div>


                            </div>

                            <div class="main-heading mb-4 mt-4">

                                <h2>Bank Details</h2>

                            </div>

                            <div class="row mb-4">

                                <div class="col-md-6">

                                    <div class="form-group clear-text">

                                        <label class="mb-2">Bank Name</label>

                                        <?php $vendorbank = isset($meta['vendor_bank_name']) ? $meta['vendor_bank_name'] : ''; ?>

                                        <input type="text" name="meta[vendor_bank_name]" required
                                            value="<?= $vendorbank ?>" placeholder="Vendor Bank Name"
                                            class="form-control">

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group clear-text">

                                        <label class="mb-2">Account Number</label>

                                        <?php $accnum = isset($meta['vendor_acc_number']) ? $meta['vendor_acc_number'] : ''; ?>

                                        <input type="text" name="meta[vendor_acc_number]" required
                                            value="<?= $accnum ?>" placeholder="Account Number" class="form-control">

                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <button href="javascript:;" type="submit" class="btn w-100">Save Changes
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2 7.57692L12.3814 7.57692L7.9322 3.13462L8.49153 2.5L14 8L8.49153 13.5L7.9322 12.8654L12.3814 8.42308L2 8.42308L2 7.57692Z"
                                                fill="#6D7D36"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection

<style type="text/css">
    .fileupload {
        display: flex;
        justify-content: center;
        align-items: center;
        align-content: center;
        flex-direction: column;
        height: 200px;
        width: 100%;
        position: relative;
        border: 1px solid rgba(0, 0, 0, .1);
        background-size: cover;
        background-position: center;
    }

    .fileupload svg {
        width: 50px;
        height: 50px;
        transform: rotate(180deg)
    }

    .fileupload figcaption {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        align-content: center;
    }

    .fileupload input#thumbnail {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        cursor: pointer;
    }

    .fileupload:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        background-size: 30px 30px;
        background-image: -webkit-linear-gradient(135deg, #F2F7F8 25%, transparent 25%, transparent 50%, #F2F7F8 50%, #F2F7F8 75%, transparent 75%, transparent);
        background-image: linear-gradient(135deg, #F2F7F8 25%, transparent 25%, transparent 50%, #F2F7F8 50%, #F2F7F8 75%, transparent 75%, transparent);
        -webkit-animation: stripes 2s linear infinite;
        animation: stripes 2s linear infinite;
    }

    .fileupload:hover:before {
        opacity: 1 !important;
        z-index: -1;
    }

    @keyframes stripes {
        0% {
            background-position: 0 0;
        }

        100% {
            background-position: 60px 30px;
        }
    }

    .doc_img {
        height: 50px;
        width: 50px;
        object-fit: contain;
        margin-bottom: 1rem
    }
</style>
