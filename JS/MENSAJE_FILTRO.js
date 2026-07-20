//Bienvenida con SweetAlert2 (una vez por sesión)

document.addEventListener('DOMContentLoaded', function () {
  var esListaDeLibros = document.getElementById('catalogo') !== null;

  if (esListaDeLibros) {
    Swal.fire({
      title: '¡Bienvenido al catálogo!',
      text: 'Aquí puedes buscar, filtrar y apartar los libros de esta categoría.',
      icon: 'info',
      confirmButtonText: 'Entendido',
      confirmButtonColor: '#1a3e1f'
    });
  } else {
    Swal.fire({
      title: 'Elige una categoría',
      text: 'Selecciona el tema que te interese para ver los libros disponibles.',
      icon: 'info',
      confirmButtonText: 'Entendido',
      confirmButtonColor: '#1a3e1f'
    });
  }
});

// VISTA (cuadrícula o lista)
function setVista(vista) {
  var catalogo = document.getElementById('catalogo');
  if (!catalogo) return;
  var btnCuadricula = document.getElementById('btn-cuadricula');
  var btnLista = document.getElementById('btn-lista');

  if (vista === 'lista') {
    catalogo.classList.add('vista-lista');
    btnLista.classList.add('activo-vista');
    btnCuadricula.classList.remove('activo-vista');
  } else {
    catalogo.classList.remove('vista-lista');
    btnCuadricula.classList.add('activo-vista');
    btnLista.classList.remove('activo-vista');
  }
  localStorage.setItem('vista-catalogo', vista);
}

document.addEventListener('DOMContentLoaded', function () {
  if (document.getElementById('catalogo')) {
    var vistaGuardada = localStorage.getItem('vista-catalogo') || 'cuadricula';
    setVista(vistaGuardada);
  }
});

// FILTRAR + ORDENAR
function filtrar() { //funcion que se ejecuta cada que escriban
  var catalogo = document.getElementById('catalogo');
  if (!catalogo) return;

  var busqueda = document.getElementById('buscador').value.toLowerCase();
  //"document" es el archivo, ".getElementby" busca los que tengan "id=buscador", ".value" obtiene lo que se escriba, y "toLowerCase" lo pasa a mayusculass
  var filtroGenero = document.getElementById('filtro-genero');
  //Lo mismo pero ahora agarra el valor del genero 
  var genero = filtroGenero ? filtroGenero.value : 'todos';
  var orden = document.getElementById('orden').value;
  var tarjetas = Array.from(catalogo.querySelectorAll('.card'));
  //busca todos los elementos que tengan la clase card, por ejemplo, los de politica o asi, y los guarda en una lista

  tarjetas.forEach(function (card) {
    //".forEach" recorre la lista de tarjetas una por una, y "card" representa la tarjeta actual
    var titulo = card.querySelector('.titulo').textContent.toLowerCase();
    var coincideBusqueda = titulo.includes(busqueda);
    //es lo que ve si lo que se busca es lo mismo que se escribio, devuelve un booleano (fake o rial)
    var coincideGenero = genero === 'todos' || card.classList.contains(genero);
    //si eligen lo de todos lo genero, devuelve verdadero, "||" es el equivalente al "o", asi si cualquiera de los dos es verdadero, devuelve verdadero
    card.classList.toggle('oculto', !(coincideBusqueda && coincideGenero));
  });

  var visibles = tarjetas.filter(function (card) {
    return !card.classList.contains('oculto');
  });

  visibles.sort(function (a, b) {
    var tA = a.querySelector('.titulo').textContent.trim().toLowerCase();
    //dentro de esa tarjeta específica, busca el elemento o clase "titulo", "textContent" obtiene el texto "puro", lo otro es lo de las minusculas
    var tB = b.querySelector('.titulo').textContent.trim().toLowerCase();
    return orden === 'az' ? tA.localeCompare(tB) : tB.localeCompare(tA);
  });

  visibles.forEach(function (card) {
    catalogo.appendChild(card);
  });
} // ← esta llave le falta