var obj_arr = new Array();

function ajax_synchro()
{
    var data_arr  = new Array();
    $('.table-holder input').each(function(){
        if($(this).data('formula')!='')
            data_arr.push( $(this).data('formula') );
        else
            data_arr.push( $(this).val() );
    })
    
    $.ajax({
        url:'ajax.php',
        data:{
            cols:$('.top-cell').size(),
            rows:$('.void-block2').size(),
            data: data_arr
        },
        dataType:'json',
        type:'post',
        success:function(result){
            for(i in result)
            {
                current_cell = $('.table-holder input').eq(i);
                if(current_cell.data('formula')!='')
                    current_val = current_cell.data('formula');
                else
                    current_val = current_cell.val();
                
                
            	if(current_cell.hasClass('seleceted-cell'))
            		continue;
            		
                current_cell.clearClasses();
                    
                if(result[i]!=false)
                    current_cell.val(result[i]);
                    
                // fix for text first 
                re_formula = /^=[A-z0-9\+\-\/\*]+$/;
                re_num = /^[0-9]+$/;
                re_link = /^=[A-z]+[0-9]+$/;
                
                //if(result[i]==false && current_cell.val()!='' && !re_num.test(current_cell.eq(i).val()) && !re_formula.test(current_cell.eq(i).val()) && !re_link.test(current_cell.val()))
//                {
                    //$('.table-holder input').eq(i).val('');
//                }
//                else
                if(result[i]==false && current_val!='')
                    current_cell.val('');
                    
                // if it's numerick
                if(re_num.test(current_val))
                {
                    current_cell.clearClasses()
                               .addClass('numeric-cell');
                } 
                
                // if is's a formula
                if(re_formula.test(current_val))
                {
                    current_cell.clearClasses()
                                .addClass('formula-cell');
                                
                    if(result[i]==false && current_val!='')
                        current_cell.val(0);    
                }
                
                 // if it's a referance
                 if(re_link.test(current_val))
                 {
                     current_cell.clearClasses();
                 }
                  
                 // if it's a text      
                 var re = /^\'[A-z0-9 ]+$$/;
                 if(re.test(current_val))
                 {
                     current_cell.clearClasses()
                                .addClass('text-cell');
                 }
            }
        },
        error:function(){
            alert('Ошибка при работе ajax запроса');
        }
    });
}

(function($) {
    
  $.fn.clearClasses = function(){
      $(this).removeClass('text-cell')
             .removeClass('formula-cell')
             .removeClass('numeric-cell');
             
      return $(this);
  }  
    
  $.fn.solve = function(){
      var value = $(this).val();
      if($.trim(value)=='')
        return false;
      
      flag = false;
      // if is's a formula
      var re = /^=[A-z0-9\+\-\/\*]+$/;
      if(re.test(value))
      {
          flag = true;
          $(this).clearClasses().addClass('formula-cell');
          $(this).data('formula', $(this).val() );
      }
      
      // if it's numerick
      var re = /^[0-9]+$/;
      if(re.test(value))
      {
          flag = true;
          $(this).clearClasses().addClass('numeric-cell');
          $(this).data('formula', $(this).val() );
      }
      
      // if it's a referance
      var re = /^=[A-z]+[0-9]+$/;
      if(re.test(value))
      {
          flag = true;
          $(this).data('formula', $(this).val() ).clearClasses().removeClass('formula-cell');
      }
      
      // if it's a text      
      var re = /^\'[A-z0-9 ]+$$/;
      if(re.test(value))
      {
          flag = true;
          $(this).clearClasses().addClass('text-cell').removeClass('formula-cell');
          $(this).data('formula', $(this).val() );
      }
      
      if(!flag)
        alert('Договорились что строковые ячейки начинаются с кавычки. Неизветный тип данных поэтому игнорируем');
      
      ajax_synchro();
      
      return this;
  };
  
  $.fn.solveComandLine = function(){
      var value = $(this).val();
      
      if($.trim(value)=='')
        return false;
      
      cell = $('.seleceted-cell');
      
      flag = false;
      
      // if is's a formula
      var re = /^=[A-z0-9\+\-\/\*]+$/;
      if(re.test(value))
      {
          flag = true;
          $(cell).clearClasses().addClass('formula-cell');
          $(cell).data('formula', $(this).val() );
      }
      
      // if it's numerick
      var re = /^[0-9]+$/;
      if(re.test(value))
      {
          flag = true;
          $(cell).clearClasses().addClass('numeric-cell').removeClass('formula-cell');
          $(cell).data('formula', $(this).val() );
      }
      
      // if it's a referance
      var re = /^=[A-z]+[0-9]+$/;
      if(re.test(value))
      {
          flag = true;
          $(cell).data('formula', $(this).val() ).clearClasses().removeClass('formula-cell');
          $(cell).data('formula', $(this).val() );
      }
      
      // if it's a text      
      var re = /^\'[A-z0-9 ]+$$/;
      if(re.test(value))
      {
          flag = true;
          $(cell).addClass('text-cell').clearClasses().removeClass('formula-cell');
          $(cell).data('formula', $(this).val() );
      }
      
      if(!flag)
        alert('Договорились что строковые ячейки начинаются с кавычки. Неизветный тип данных поэтому игнорируем');
      
      ajax_synchro();
      
      return this;
  };
})(jQuery);


$(document).ready(function(){
    var line_arr = $('.line'); 
    
    $('.cell input').val('');
    
    $('.cell').live('mouseenter',function(){
        var row = line_arr.index($(this).parent());
        var cow = $('.top-cell').eq($(this).parent().find('.cell').index(this)).html();
        $('#status-line').html( cow + '' + row );
    });
    
    $('.cell input').live('focus',function(){
        
        parent_cell = $(this).parent();
        var row = line_arr.index($(this).parent().parent());
        var cow = $('.top-cell').eq($(parent_cell).parent().find('.cell').index(parent_cell)).html();
        $('#nav').val( cow + '' + row );
        
        if($(this).data('formula')!='')
        	$(this).val( $(this).data('formula') );
        
        $('#line').val( $(this).val() );
        
        $('.seleceted-cell').removeClass('seleceted-cell');
        $(this).addClass('seleceted-cell');
    })
    
    $('.cell').live('mouseleave',function(){
        $('#status-line').html('');
    })
    
    $('.cell input').live('keyup',function(event){
        $('#line').val( $(this).val() );
        
        if (event.keyCode == '13')
            $(this).solve();
    })
    $('.cell input').live('blur',function(){
        $(this).solve();        
    })
    
        
    $('#line').keyup(function(event){
        
        $('.seleceted-cell').val( $(this).val() );
        
        if (event.keyCode == '13')
        {
            $('#line').solveComandLine();
        }
    })  
    $('#line').blur(function(){
        $('#line').solveComandLine();
    })
    
    $('.cell input').live('focus',function(){
        $('#line').val( $(this).val() );
    })
})