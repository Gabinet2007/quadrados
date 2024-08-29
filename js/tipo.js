const escolhaQuad = document.getElementsByName('escolhaQuad');
const imagemInput = document.getElementById('imagem');
const corInput = document.getElementById('cor');

function mostrarInput(inputId) {
    imagemInput.style.display = inputId === 'img' ? 'block' : 'none';
    corInput.style.display = inputId === 'color' ? 'block' : 'none';
}

mostrarInput();

escolhaQuad.forEach((radio) => {
    radio.addEventListener('change', () => {
        mostrarInput(radio.value);
    });
});