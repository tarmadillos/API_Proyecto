// Variable para guardar el token (el pase de entrada)
let token = localStorage.getItem('token');
const API_URL = 'http://localhost/apirestphp/';

// Si ya hay un token, mostramos la sección principal
if (token) {
    document.getElementById('login-section').style.display = 'none';
    document.getElementById('main-section').style.display = 'block';
}

// Función para iniciar sesión
async function login() {
    // Obtenemos el usuario y la contraseña que escribió el usuario
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const message = document.getElementById('login-message');

    // Enviamos una solicitud a la API para iniciar sesión
    try {
        const response = await fetch(`${API_URL}/auth/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, password })
        });

        const data = await response.json();
        if (response.ok) {
            // Si todo está bien, guardamos el token y mostramos la sección principal
            token = data.token;
            localStorage.setItem('token', token);
            message.textContent = '¡Bienvenido!';
            message.classList.add('success');
            document.getElementById('login-section').style.display = 'none';
            document.getElementById('main-section').style.display = 'block';
        } else {
            // Si hay un error, mostramos un mensaje
            message.textContent = 'Usuario o contraseña incorrectos';
        }
    } catch (error) {
        message.textContent = 'Hubo un problema al conectar con la tienda';
    }
}

// Función para mostrar los productos
async function fetchProducts() {
    const productsList = document.getElementById('products-list');

    try {
        const response = await fetch(`${API_URL}/productos`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        const products = await response.json();
        if (response.ok) {
            // Mostramos cada producto en la lista
            productsList.innerHTML = '';
            products.forEach(product => {
                const li = document.createElement('li');
                li.textContent = `Producto: ${product.Nombre} - Precio: $${product.Precio}`;
                productsList.appendChild(li);
            });
        } else {
            productsList.innerHTML = '<li>No se pudieron cargar los productos</li>';
        }
    } catch (error) {
        productsList.innerHTML = '<li>Hubo un problema al conectar con la tienda</li>';
    }
}

// Función para mostrar las ventas
async function fetchSales() {
    const salesList = document.getElementById('sales-list');

    try {
        const response = await fetch(`${API_URL}/ventas`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        const sales = await response.json();
        if (response.ok) {
            // Mostramos cada venta en la lista
            salesList.innerHTML = '';
            sales.forEach(sale => {
                const li = document.createElement('li');
                li.textContent = `Venta ID: ${sale.ID_Venta} - Cliente: ${sale.Cliente_Nombre} - Fecha: ${sale.Fecha_Venta}`;
                salesList.appendChild(li);
            });
        } else {
            salesList.innerHTML = '<li>No se pudieron cargar las ventas</li>';
        }
    } catch (error) {
        salesList.innerHTML = '<li>Hubo un problema al conectar con la tienda</li>';
    }
}

// Función para cerrar sesión
function logout() {
    localStorage.removeItem('token');
    token = null;
    document.getElementById('login-section').style.display = 'block';
    document.getElementById('main-section').style.display = 'none';
    document.getElementById('login-message').textContent = '';
    document.getElementById('products-list').innerHTML = '';
    document.getElementById('sales-list').innerHTML = '';
}