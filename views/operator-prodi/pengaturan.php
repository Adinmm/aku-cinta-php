<?php
/**
 * LRsoft Corp.
 * https://lrsoft.id
 *
 * Author : Zaf
 */

global $page_title; ?>

<div class="ibox float-e-margins">

    <?php echo Helpers::_notif_crud('Perbarui', Routes::_gi()->_depth(2), '{{action}} ' . $page_title . ' {{status}}.'); ?>

    <div class="ibox-title">
        <h5>Pengaturan</h5>
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

        <form action="<?php echo Helpers::_a_op(Helpers::op_pengaturan, true); ?>"
              enctype="multipart/form-data"
              method="post"
              class="form-horizontal">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="tahun_akademik_aktif">
                            Tahun Akademik
                        </label>
                        <div class="col-sm-8 col-md-4">
                            <input type="text" id="tahun_akademik_aktif" name="pengaturan[tahun_akademik_aktif]"
                                   class="form-control"
                                   data-mask="99999"
                                   value="<?php echo CPengaturan::_gi()->_get('tahun_akademik_aktif', date('Y1')); ?>"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="pengumuman">
                            Pengumuman
                        </label>
                        <div class="col-sm-8">
                            <textarea id="pengumuman" name="pengaturan[pengumuman]" rows="5"
                                      class="form-control"><?php echo CPengaturan::_gi()->_get('pengumuman'); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="kaprodi_nama">
                            Kaprodi
                        </label>
                        <div class="col-sm-8">
                            <select id="kaprodi_nama" name="pengaturan[kaprodi_nama]"
                                    class="form-control">
                                <option value="<?php echo CPengaturan::_gi()->_get('kaprodi_nama'); ?>">
                                    <?php echo CPengaturan::_gi()->_get('kaprodi_nama'); ?>
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="kaprodi_nip"></label>
                        <div class="col-sm-8 col-md-4">
                            <input type="text" id="kaprodi_nip" name="pengaturan[kaprodi_nip]"
                                   class="form-control"
                                   value="<?php echo CPengaturan::_gi()->_get('kaprodi_nip'); ?>"/>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $('#kaprodi_nama').select2({
                            ajax: {
                                url: '<?php echo Helpers::_api(Helpers::api_dosen); ?>',
                                dataType: 'json',
                                data: function (params) {
                                    return {
                                        nama: params.term,
                                        number: 100
                                    }
                                },
                                processResults: function (response) {
                                    var results = [];
                                    $.each(response, function (index, item) {
                                        results.push({
                                            id: item.nama,
                                            text: item.nama,
                                            desc: item.NIP,
                                        });
                                    });
                                    return {
                                        results: results
                                    }
                                },
                                cache: true
                            },
                            placeholder: 'Pilih Dosen',
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            minimumInputLength: 1,
                            templateResult: function (item) {
                                if (item.loading)
                                    return item.text;

                                return '<strong>' + item.text + '</strong><br/>' +
                                    '<small>' + item.desc + '</small>';
                            },
                            templateSelection: function (item) {
                                if (item.desc)
                                    $('#kaprodi_nip').val(item.desc);
                                return item.text;
                            }
                        });
                    </script>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="sekprodi_nama">
                            Sekprodi
                        </label>
                        <div class="col-sm-8">
                            <select id="sekprodi_nama" name="pengaturan[sekprodi_nama]"
                                    class="form-control">
                                <option value="<?php echo CPengaturan::_gi()->_get('sekprodi_nama'); ?>">
                                    <?php echo CPengaturan::_gi()->_get('sekprodi_nama'); ?>
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="sekprodi_nip"></label>
                        <div class="col-sm-8 col-md-4">
                            <input type="text" id="sekprodi_nip" name="pengaturan[sekprodi_nip]"
                                   class="form-control"
                                   value="<?php echo CPengaturan::_gi()->_get('sekprodi_nip'); ?>"/>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $('#sekprodi_nama').select2({
                            ajax: {
                                url: '<?php echo Helpers::_api(Helpers::api_dosen); ?>',
                                dataType: 'json',
                                data: function (params) {
                                    return {
                                        nama: params.term,
                                        number: 100
                                    }
                                },
                                processResults: function (response) {
                                    var results = [];
                                    $.each(response, function (index, item) {
                                        results.push({
                                            id: item.nama,
                                            text: item.nama,
                                            desc: item.NIP,
                                        });
                                    });
                                    return {
                                        results: results
                                    }
                                },
                                cache: true
                            },
                            placeholder: 'Pilih Dosen',
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            minimumInputLength: 1,
                            templateResult: function (item) {
                                if (item.loading)
                                    return item.text;

                                return '<strong>' + item.text + '</strong><br/>' +
                                    '<small>' + item.desc + '</small>';
                            },
                            templateSelection: function (item) {
                                if (item.desc)
                                    $('#sekprodi_nip').val(item.desc);
                                return item.text;
                            }
                        });
                    </script>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="exclude_pembayaran">
                            Exclude<br/>
                            <small class="text-muted">
                                Pembayaran Mahasiswa
                            </small>
                        </label>
                        <div class="col-sm-8">
                            <select id="exclude_pembayaran" name="pengaturan[exclude_pembayaran][]" multiple
                                    class="form-control">
                                <?php if ($_mahasiswa = json_decode(CPengaturan::_gi()->_get('exclude_pembayaran'))):
                                    foreach ($_mahasiswa as $__nim):
                                        $_obj_mahasiswa = CMahasiswa::_gi()->_get($__nim);
                                        if (!$_obj_mahasiswa) continue; ?>
                                        <option value="<?php echo $__nim; ?>" selected>
                                            <?php printf('%s (%s)', $_obj_mahasiswa->getMahasiswaNama(), $_obj_mahasiswa->getMahasiswaNim()); ?>
                                        </option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $('#exclude_pembayaran').select2({
                            ajax: {
                                url: '<?php echo Helpers::_api(Helpers::api_mahasiswa); ?>',
                                dataType: 'json',
                                data: function (params) {
                                    return {
                                        NIM_nama: params.term,
                                        kode_prodi: <?php echo PRODI_KODE; ?>,
                                        number: 50,
                                        _insert: true,
                                    }
                                },
                                processResults: function (response) {
                                    var results = [];
                                    $.each(response, function (index, item) {
                                        results.push({
                                            id: item.id,
                                            text: item.nama,
                                            desc: item.prodi,
                                        });
                                    });
                                    return {
                                        results: results
                                    }
                                },
                                cache: true
                            },
                            placeholder: 'Pilih Mahasiswa',
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            minimumInputLength: 3,
                            templateResult: function (item) {
                                if (item.loading)
                                    return item.text;

                                return '<strong>' + item.text + '</strong><br/>' +
                                    '<small>' + item.desc + '</small>';
                            },
                            templateSelection: function (item) {
                                return item.text;
                            }
                        });
                    </script>

                </div>

                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="dekan_nama">
                            Dekan
                        </label>
                        <div class="col-sm-8">
                            <select id="dekan_nama" name="pengaturan[dekan_nama]"
                                    class="form-control">
                                <option value="<?php echo CPengaturan::_gi()->_get('dekan_nama'); ?>">
                                    <?php echo CPengaturan::_gi()->_get('dekan_nama'); ?>
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 control-label" for="dekan_nip"></label>
                        <div class="col-sm-8 col-md-4">
                            <input type="text" id="dekan_nip" name="pengaturan[dekan_nip]"
                                   class="form-control"
                                   value="<?php echo CPengaturan::_gi()->_get('dekan_nip'); ?>"/>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $('#dekan_nama').select2({
                            ajax: {
                                url: '<?php echo Helpers::_api(Helpers::api_dosen); ?>',
                                dataType: 'json',
                                data: function (params) {
                                    return {
                                        nama: params.term,
                                        number: 10
                                    }
                                },
                                processResults: function (response) {
                                    var results = [];
                                    $.each(response, function (index, item) {
                                        results.push({
                                            id: item.nama,
                                            text: item.nama,
                                            desc: item.NIP,
                                        });
                                    });
                                    return {
                                        results: results
                                    }
                                },
                                cache: true
                            },
                            placeholder: 'Pilih Dosen',
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            minimumInputLength: 1,
                            templateResult: function (item) {
                                if (item.loading)
                                    return item.text;

                                return '<strong>' + item.text + '</strong><br/>' +
                                    '<small>' + item.desc + '</small>';
                            },
                            templateSelection: function (item) {
                                if (item.desc)
                                    $('#dekan_nip').val(item.desc);
                                return item.text;
                            }
                        });
                    </script>

                    <?php foreach (range(1, 3) as $_i) : ?>

                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="wd<?php echo $_i; ?>_nama">
                                WD <?php echo $_i; ?>
                            </label>
                            <div class="col-sm-8">
                                <select id="wd<?php echo $_i; ?>_nama" name="pengaturan[wd<?php echo $_i; ?>_nama]"
                                        class="form-control">
                                    <option value="<?php echo CPengaturan::_gi()->_get('wd' . $_i . '_nama'); ?>">
                                        <?php echo CPengaturan::_gi()->_get('wd' . $_i . '_nama'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-4 control-label" for="wd<?php echo $_i; ?>_nip"></label>
                            <div class="col-sm-8 col-md-4">
                                <input type="text" id="wd<?php echo $_i; ?>_nip"
                                       name="pengaturan[wd<?php echo $_i; ?>_nip]"
                                       class="form-control"
                                       value="<?php echo CPengaturan::_gi()->_get('wd' . $_i . '_nip'); ?>"/>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $('#wd<?php echo $_i; ?>_nama').select2({
                                ajax: {
                                    url: '<?php echo Helpers::_api(Helpers::api_dosen); ?>',
                                    dataType: 'json',
                                    data: function (params) {
                                        return {
                                            nama: params.term,
                                            number: 10
                                        }
                                    },
                                    processResults: function (response) {
                                        var results = [];
                                        $.each(response, function (index, item) {
                                            results.push({
                                                id: item.nama,
                                                text: item.nama,
                                                desc: item.NIP,
                                            });
                                        });
                                        return {
                                            results: results
                                        }
                                    },
                                    cache: true
                                },
                                placeholder: 'Pilih Dosen',
                                escapeMarkup: function (markup) {
                                    return markup;
                                },
                                minimumInputLength: 1,
                                templateResult: function (item) {
                                    if (item.loading)
                                        return item.text;

                                    return '<strong>' + item.text + '</strong><br/>' +
                                        '<small>' + item.desc + '</small>';
                                },
                                templateSelection: function (item) {
                                    if (item.desc)
                                        $('#wd<?php echo $_i; ?>_nip').val(item.desc);
                                    return item.text;
                                }
                            });
                        </script>

                    <?php endforeach; ?>

                </div>
            </div>

            <div class="text-center">
                <br/><br/>

                <button class="btn btn-success btn-outline">
                    <i class="fa fa-cloud-upload"></i>
                    &nbsp;Simpan
                </button>

            </div>

        </form>

    </div>

</div>