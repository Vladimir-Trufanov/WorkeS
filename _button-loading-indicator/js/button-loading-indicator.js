'use strict';

$(document).ready(function () {
   var $button = $('button[type="submit"]');
   $button.on('click', function () 
   {
      var $this = $(this);
      if ($this.hasClass('active') || $this.hasClass('success')) 
      {
	     return false;
      }
	  $this.addClass('active');
	  setTimeout(function () 
      {
         $this.addClass('loader');
      }, 125);
      setTimeout(function () 
      {
         $this.removeClass('loader active');
		 $this.text('Успешно!');
		 $this.addClass('success animated pulse');
      }, 1600);
      setTimeout(function () 
      {
         $this.text('Загрузить ещё');
         $this.removeClass('success animated pulse');
         $this.blur();
      }, 2900);
  });
});