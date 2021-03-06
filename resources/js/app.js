require('./bootstrap');

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(function () {
  $(".chosen-select").chosen();
})

$(document).ready(function () {
  $(document).on('submit', '[name="search-user"]', function (e) {
      e.preventDefault();
      var form = document.querySelector('[name="search-user"]');
      var data = new FormData(form);

      if (!data.get('search')) {
            var search = document.querySelector('[name="search"]');
            search.setAttribute('placeholder', 'Часть имени или фамилии');
      } else {
        axios.post(form.action, data)
        .then(function (response) {
            $('#user-search-result').html(response.data.html);
        })
        .catch(function (error) {
          $('.toast-header').addClass('bg-danger');
          $('.toast-header').removeClass('bg-success');
          $('.toast-body').html('Что-то пошло не так. Попробуйте ещё раз или сообщите нам');
          $('.toast').toast('show');
        });
      }
  });
});

$(document).ready(function () {
  $(document).on('click', '.del-reason, .del-theme', function (e) {
      e.preventDefault();
      var _this = $(this)
        axios.post($(this).attr('url'), {
            name: this.name
        })
        .then(function (response) {
          if(response.data.success == true) {
            _this.parent().parent().remove();
          } else {
            $('.toast-header').addClass('bg-danger');
            $('.toast-header').removeClass('bg-success');
            $('.toast-body').html('Что-то пошло не так. Попробуйте ещё раз или сообщите нам');
            $('.toast').toast('show');
          }
        })
        .catch(function (error) {
          $('.toast-header').addClass('bg-danger');
          $('.toast-header').removeClass('bg-success');
          $('.toast-body').html('Что-то пошло не так. Попробуйте ещё раз или сообщите нам');
          $('.toast').toast('show');
        });
      });
});

$(document).ready(function () {
  $(document).on('click', '.del-role', function (e) {
      e.preventDefault();
      var _this = $(this)
        axios.post($(this).attr('url'), {
            name: this.name
        })
        .then(function (response) {
          if(response.data.success == true) {
            _this.parent().parent().remove();
          } else {
            $('.toast-header').addClass('bg-danger');
            $('.toast-header').removeClass('bg-success');
            $('.toast-body').html('Что-то пошло не так. Попробуйте ещё раз или сообщите нам');
            $('.toast').toast('show');
          }
        })
        .catch(function (error) {
          $('.toast-header').addClass('bg-danger');
          $('.toast-header').removeClass('bg-success');
          $('.toast-body').html('Что-то пошло не так. Попробуйте ещё раз или сообщите нам');
          $('.toast').toast('show');
        });
      });
});

$(document).ready(function () {
  $(document).on('click', '.defrost', function (e) {
    if (document.getElementById("defrost").checked) {
      $('.defrost').removeClass('text-muted');
      $("#temperature").attr("disabled", false);
      $(".label-defrost").text('Температура:');
    } else {
      $('.defrost').addClass('text-muted');
      $("#temperature").attr("disabled", true);
      $(".label-defrost").text('Разморозка:');
      $(".output-defrost").text('');
    }

  });
});

$(document).ready(function () {
  $(document).on('click', '.view-all-table', function (e) {
    $('.view-all-table').toggleClass('text-muted');
    $('.view-all').toggleClass('d-none');
    $('.view-all-form').toggleClass('visiblility');
    $('.view-all-container').toggleClass('container-xl');
    $('.view-all-container').toggleClass('container-fluid');
  });
});
