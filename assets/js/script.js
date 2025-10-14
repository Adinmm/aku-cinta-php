$(document).ready(function () {

    $('.__select2').select2();

    $('a.hapus').on('click', function (e) {
        e.preventDefault();
        if (confirm('Yakin ingin menghapus ?'))
            window.location.replace($(this).attr('href'));
    });

    $('a.confirm').on('click', function (e) {
        e.preventDefault();
        if (confirm('Apakah anda yakin?'))
            window.location.replace($(this).attr('href'));
    });

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('.__tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('.__jam').clockpicker({
        donetext: 'Pilih'
    });

    $('.__generate_ttd').on('click', function (e) {
        e.preventDefault();

        const _this = $(this);
        const _btn = _this.ladda();
        const btnSave = $('#' + _this.attr('data-id-btn-save'));
        const imgFoto = $('#' + _this.attr('data-id-foto'));
        const inputDataKode = $('#' + _this.attr('data-id-data-kode'));
        const inputDataFoto = $('#' + _this.attr('data-id-data-foto'));
        const textKeterangan = _this.attr('data-keterangan');

        _btn.ladda('start');

        $.ajax({
            url: '/index.php/api/tanda-tangan',
            dataType: 'json',
            type: 'post',
            data: {tanda_tangan_keterangan: textKeterangan},
            success: function (results) {

                if (results.status) {

                    inputDataKode.val(results.data.tanda_tangan_kode);
                    inputDataFoto.val(results.data.tanda_tangan_foto);

                    imgFoto.attr('src', results.data.tanda_tangan_foto);
                    imgFoto.fadeIn();

                    btnSave.attr('disabled', false);

                } else alert(results.data);

                _btn.ladda('stop');

            }
        });

    });

});