$(document).ready(function(){
  $('[data-bs-toggle="tooltip"]').tooltip();
});


$(document).ready(function(){

//check New Task input
  $('#NewTodo').change(function(){
    if ($.trim($('#NewTodo').val())) {
      $('.btn-submit').attr('disabled',false);
    }else {
      $('.btn-submit').attr('disabled',true);
    }

  });


//Options Toggle
  $('#NewTodo').focus(function(){
    $('.options').slideDown();
  });

//Option Buttons
  function remove_click(button) {
    if (button == 'general') {
      $('#general').data('clicked',false);
      $('#general').removeClass('btn-secondary');
      $('#general').addClass('btn-outline-secondary');
    }

    if (button == 'today') {
      $('#today').data('clicked') == false
      $('#today').removeClass('btn-primary');
      $('#today').addClass('btn-outline-primary');
    }
  }

  function add_click(button) {
    if (button == 'general') {
      $('#general').removeClass('btn-outline-secondary');
      $('#general').addClass('btn-secondary');
      $('#general').data('clicked',true);
    }

    if (button == 'today') {
      $('#today').removeClass('btn-outline-primary');
      $('#today').addClass('btn-primary');
      $('#today').data('clicked',true);
    }
  }


  $('#today').click(function(){
    if ($('#general').data('clicked') == true) {

      remove_click('general');
    }
    $(this).removeClass('btn-outline-primary');
    $(this).addClass('btn-primary');
    $(this).data('clicked',true);
  });

  $('#general').click(function(){
    if ($('#today').data('clicked') == true) {

      remove_click('today');
    }
    $(this).removeClass('btn-outline-secondary');
    $(this).addClass('btn-secondary');
    $(this).data('clicked',true);
  });

  //Keyboard shortcuts
  $('#NewTodo').keypress(function(event) {
    if(event.which == 9){
      event.preventDefault();
      add_click('general');
      remove_click('today');
    }
    if (event.which == 18) {
      event.preventDefault();
      add_click('today');
      remove_click('general');
    }

  });


//Send data to database
$('#addTodo').submit(function(event){
  event.preventDefault();



var $form = $(this),
  todo = $form.find("input[name='NewTodo']").val();
  lastid = $(".btn-submit").data('lastid');
  newid = Number(lastid)+1;
  category = 'today';

if ($('#general').data('clicked') == true) {
  category = 'general';
}

var posting = $.post('add-todo.php',{
  todo: todo,
  category: category
});

  posting.done(function() {
    if (category === 'today') {
      $('.todays-list').append('<div class="form-check" id="'+(newid)+'"><input class="form-check-input check" type="checkbox" data-id="'+newid+'" id="check'+newid+'"><label class="form-check-label" for="check'+newid+'">'+todo+'</label></div>');
    }else if (category === 'general') {
      $('.general-list').append('<div class="form-check" id="'+(newid)+'"><input class="form-check-input check" type="checkbox" data-id="'+newid+'" id="check'+newid+'"><label class="form-check-label" for="check'+newid+'">'+todo+'</label></div>');
    }

    $('#check'+newid).click(function(){
      remove_item(newid);
    });
    $($form.find("input[name='NewTodo']").val(""));
    $('#general').data('clicked') == false;
    $('#today').data('clicked') == false;
    remove_click();
    $('.options').slideUp();
    $('.btn-submit').attr('disabled',true);
  });

});



//Remove item from list
  function remove_item(id) {
    var deleting = $.post('dlt-todo.php',{
      delete_id: id
    });

    deleting.done(function(){
      $('#'+id).remove();
      $('.alert-delete').show();
      setTimeout(function(){ $('.alert-delete').hide(); }, 3000);
    })


  }


  $('.check').change(function(){
      let btn = $(this);
      let id = btn.data('id');
    if ($(btn).prop('checked') == true){
      remove_item(id);

    }

  });

});
