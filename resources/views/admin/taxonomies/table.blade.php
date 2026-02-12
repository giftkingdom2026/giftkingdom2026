<table id="example1" class="table table-bordered table-striped">

    <thead>

        <tr>

            <th>ID</th>

            <th>Title</th>

            <th>Slug</th>

            <th>Actions</th>

        </tr>

    </thead>

    <tbody class="draggable-container">


        <?php
        
        !empty( $data['terms'] ) ? $first = reset($data['terms'])['sort_order'] : ''; ?>

        @foreach ( $data['terms'] as  $key=> $term )


        <tr class="shallow-draggable" draggable="true" start="<?=$first?>"  sort-order="<?=$term['sort_order']?>" id=<?=$term['terms_id']?> type="terms">

            <td>{{$term['terms_id']}}</td>

            <div class="actions"></div>

            <td>{{$term['term_title']}}</td>

            <td>{{$term['term_slug']}}</td>

            <td class="careerFilter">

                <div class="child_option position-relative">

                    <button class="dots open-menu2 bg-transparent border-0 p-0" type="button"><svg height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path></svg></button> 

                    <div class="dropdown-menu2 dropdown-menu-right" style="display: none;">   

                        <ul class="careerFilterInr">

                            <li>
                                <a href="<?=asset('admin/taxonomy/edit/'.$term['terms_id'] )?>" class="w-100 border-0 d-flex justify-content-between">
                                    Edit
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15" height="15"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:delete_popup('<?=asset('admin/taxonomy/delete')?>',<?=$term['terms_id']?>);" class="w-100 border-0 d-flex justify-content-between">
                                    Delete
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>                                        

            </td>



        </tr>

        @endforeach

    </tbody>

</table>


