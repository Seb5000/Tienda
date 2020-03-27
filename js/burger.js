const navSlide = () =>{
	const burger = document.querySelector('.burger');
	const nav = document.querySelector('.nav-links');
	const navl = document.querySelectorAll('.nav-links li')
	burger.addEventListener('click', ()=>{

		//cambiar de clase a los links
		nav.classList.toggle('nav-active');

		//animar los links
		navl.forEach((link, index)=>{
			if(link.style.animation){
				link.style.animation='';
			}else{
				link.style.animation = `menufade 0.5 ease forwards ${index / 7 + 2}s`;
			}
		});

		//animacion amburguesa
		burger.classList.toggle('rotar');
	});

	
}

navSlide();