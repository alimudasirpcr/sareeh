<div class="card-header">
    <h4 class="card-title">sales</h4>
    <?php  $columns = get_table_columns('sales'); 
                $columnSearch = array_filter($columns, function($key) {
                    return $key !== 'default_order';
                }, ARRAY_FILTER_USE_KEY);
                
    ?>

    <form id="config_columns">
        <div class="piluku-dropdown btn-group table_buttons">
            <button type="button" class="btn btn-more btn-light btn-active-light-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="ion-gear-a"></i>
            </button>

            <ul id="sortable" class="dropdown-menu dropdown-menu-right col-config-dropdown ui-sortable" role="menu" style="">
                <li class="dropdown-header"><a id="reset_to_default" class="pull-right"><span class="ion-refresh"></span> Reset</a>Column Configuration</li>
            <?php $i=0; foreach($columns as $key => $col): ?>
                <li class="sort">
                    <a class="d-flex justify-content-space-between ">
                        <div class="form-check">
                            <input type="checkbox" class="toggle-vis form-check-input" data-column-index="<?= $i ?>" id="check<?= $i ?>" checked>
                            <label class="form-check-label" for="check<?= $i ?>"><span></span><?= $col ?></label>
                        </div>
                        <span class="handle ion-drag"></span>
                    </a>
                </li>
            <?php $i++; endforeach ?>
            </ul>
        </div>
    </form>
</div>