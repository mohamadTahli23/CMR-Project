//jQuery time
var current_fs, next_fs, previous_fs; //forms
var left, opacity, scale; //form properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
  console.log(current_fs);
	next_fs = $(this).parent().next();
	
	current_fs.animate({opacity: 0}, {
    step: function(now, mx) {
      current_fs.hide(200);
		}, 
		duration: 800, 
		complete: function(){
      next_fs.show(300); 
      animating = false;
		}, 
		//this comes from the custom easing plugin
	});
});



const inputElements = [...document.querySelectorAll('input.code-input')]

inputElements.forEach((ele,index)=>{
  ele.addEventListener('keydown',(e)=>{
    if(e.keyCode === 8 && e.target.value==='') inputElements[Math.max(0,index-1)].focus()
  })
  ele.addEventListener('input',(e)=>{

    const [first,...rest] = e.target.value
    e.target.value = first ?? '' // first will be undefined when backspace was entered, so set the input to ""
    const lastInputBox = index===inputElements.length-1
    const didInsertContent = first!==undefined
    if(didInsertContent && !lastInputBox) {
      inputElements[index+1].focus()
      inputElements[index+1].value = rest.join('')
      inputElements[index+1].dispatchEvent(new Event('input'))
    }
  })
})


// mini example on how to pull the data on submit of the form
function onSubmit(e){
  e.preventDefault()
  const code = inputElements.map(({value})=>value).join('')
  console.log(code)
}









