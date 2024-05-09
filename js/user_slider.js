const sliderLine = document.querySelector('.slider-line');
const blocks = document.querySelectorAll('.block_new');
const blockWidth = blocks[0].offsetWidth;
let offset = 0;

sliderLine.style.width = blockWidth * blocks.length + 'px';

document.querySelector('.slider-next').addEventListener('click', function () {
	offset += blockWidth;
	if (offset > blockWidth * (blocks.length - 1)) {
		offset = 0;
	}
	sliderLine.style.transform = 'translateX(-' + offset + 'px)';
});

document.querySelector('.slider-prev').addEventListener('click', function () {
	offset -= blockWidth;
	if (offset < 0) {
		offset = blockWidth * (blocks.length - 1);
	}
	sliderLine.style.transform = 'translateX(-' + offset + 'px)';
});
