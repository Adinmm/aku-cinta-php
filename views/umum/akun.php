<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title, $obj_operator, $_page, $_operator_id;

$_operator_metas = $obj_operator->getOperatorMetas('array'); ?>

<div class="ibox float-e-margins">

    <?php echo Helpers::_notif_crud('Perbarui', Routes::_gi()->_depth(2), '{{action}} ' . $page_title . ' {{status}}.'); ?>

    <div class="ibox-title">
        <h5>Biodata</h5>
        <div class="ibox-tools">
            <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="fullscreen-link">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="ibox-content">

        <form action="<?php echo Helpers::_a_u(Helpers::page_akun . DS . Helpers::$_dir_map[$_page] . ($_operator_id ? (DS . $_operator_id) : ''), true); ?>"
              enctype="multipart/form-data"
              method="post"
              class="form-horizontal">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="operator_nama">
                            Nama Lengkap
                        </label>
                        <div class="col-sm-8">
                            <input type="text" id="operator_nama" name="operator_nama" class="form-control"
                                   value="<?php echo $obj_operator->getOperatorNama(); ?>"/>
                        </div>
                    </div>

                    <?php foreach ($_operator_metas as $_k => $_v) : ?>
                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="operator_metas[<?php echo $_k; ?>]">
                                <?php echo Helpers::_camel_case($_k, '_'); ?>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" id="operator_metas[<?php echo $_k; ?>]"
                                       name="operator_metas[<?php echo $_k; ?>]"
                                       class="form-control"
                                       value="<?php echo $_v; ?>"/>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="operator_username">
                            Username
                        </label>
                        <div class="col-sm-8 col-md-4">
                            <p class="form-control-static"><?php echo $obj_operator->getOperatorUsername(); ?></p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="operator_password_new">
                            Password
                        </label>
                        <div class="col-sm-8 col-md-4">
                            <input type="password" id="operator_password_new" name="operator_password_new"
                                   class="form-control"/>
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti password.</small>
                        </div>
                    </div>

                    <?php if ($_operator_id) : ?>
                        <br/>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">
                                Jenis
                            </label>

                            <div class="col-sm-8">
                                <?php foreach (COperator::$_jenis as $_v) : ?>
                                    <div class="i-checks">
                                        <label class="text-muted">
                                            <input type="checkbox" name="operator_jenis[]"
                                                   value="<?php echo $_v; ?>" <?php echo $obj_operator->hasOperatorJenis($_v) ? 'checked' : ''; ?>/>
                                            &nbsp;&nbsp;<?php echo Helpers::_camel_case($_v); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <div class="text-center">
                <br/><br/>

                <input type="hidden" name="_page" value="<?php echo $_page; ?>"/>
                <input type="hidden" name="_operator_token" value="<?php echo $_page; ?>"/>

                <button class="btn btn-success btn-outline">
                    <i class="fa fa-cloud-upload"></i>
                    &nbsp;Simpan
                </button>

            </div>

        </form>

    </div>

</div>