alert(x);

const x = "\"Bienvenido al catálogo de la biblioteca Amoxcalli\""

// BARRA DE BÚSQUEDA Y FILTRO POR GÉNERO
function filtrar() { //funcion que se ejecuta cada que escriban
  var busqueda = document.getElementById('buscador').value.toLowerCase();
  //"document" es el archivo, ".getElementby" busca los que tengan "id=buscador", ".value" obtiene lo que se escriba, y "toLowerCase" lo pasa a mayusculass
  var genero = document.getElementById('filtro-genero').value;
  //Lo mismo pero ahora agarra el valor del genero 
  var tarjetas = document.querySelectorAll('.card');
  //busca todos los elementos que tengan la clase card, por ejemplo, los de politica o asi, y los guarda en una lista

  tarjetas.forEach(function (card) {
    //".forEach" recorre la lista de tarjetas una por una, y "card" representa la tarjeta actual
    var titulo = card.querySelector('.titulo').textContent.toLowerCase();
    //dentro de esa tarjeta específica, busca el elemento o clase "titulo", "textContent" obtiene el texto "puro", lo otro es lo de las minusculas
    var coincideBusqueda = titulo.includes(busqueda);
    //es lo que ve si lo que se busca es lo mismo que se escribio, devuelve un booleano (fake o rial)
    var coincideGenero = genero === 'todos' || card.classList.contains(genero);
    //si eligen lo de todos lo genero, devuelve verdadero, "||" es el equivalente al "o", asi si cualquiera de los dos es verdadero, devuelve verdadero

    if (coincideBusqueda && coincideGenero) { //un if para;
      card.style.display = 'block';//muestra la tarjeta
    } else {
      card.style.display = 'none';//oculta la tarjeta
    }
  });
}