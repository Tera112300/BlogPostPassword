$(function () {
   const $INPUT_STATUS = $("input[name='data[BlogPostPassword][status]'");
   $(window).on("load",function(){
      // pass_status($("input[name='data[BlogPostPassword][status]']:checked").val());
      pass_status($INPUT_STATUS.filter(":checked").val());
   })
   $("input[name='data[BlogPostPassword][status]'").change(function(){     
      console.log($(this).val()); 
      pass_status($(this).val());
   });

   
   function pass_status(status_val){
   if(1 === Number(status_val)){
      $("#BlogPostPasswordName").parents(".pass-textbox").removeClass("display-none");
   }else{
      $("#BlogPostPasswordName").val("").parents(".pass-textbox").addClass("display-none");
   }
   }
});
