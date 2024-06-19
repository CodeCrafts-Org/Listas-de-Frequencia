/**
 * @param {Event} event 
 * @return {Promise<void>}
 */
async function handleLoad(event) {
    const container = document.querySelector('.lista-de-frequencia__details');
    if (container === null) {
        return;
    }
    const listaId = container.dataset.id;
    await handleFetch(listaId);
}

/**
 * @param {number} id
 * @return {Promise<void>}
 */
async function handleFetch(id) {
    const listaData = document.querySelector('.form--data');
    if (listaData === null) {
        return;
    }
    const frequenciasListing = document.querySelector('.listing__items');
    if (frequenciasListing === null) {
        return;
    }
    frequenciasListing.replaceChildren();
    const wordPressRestClient = new WordPressRestClient();
    const endpoint = `codecrafts/listas-de-frequencia/v1/listas/${id}`;
    const details = await wordPressRestClient.get(endpoint);
    if (details === null) {
        renderError(frequenciasListing);
    } else if (details.frequencias.length === 0) {
        renderEmpty(frequenciasListing);
    } else {
        renderItems(frequenciasListing, details.frequencias);
    }
    renderDetails(listaData, details.listaDeFrequencia);
    return;
}

/**
 * @param {Element} tableBody 
 * @return {void}
 */
function renderError(tableBody) {
    const errorTemplate = document.getElementById('listing--error');
    if (errorTemplate === null) {
        return;
    }
    const errorElement = errorTemplate.content.cloneNode(true);
    tableBody.appendChild(errorElement);
}

/**
 * @param {Element} tableBody 
 * @return {void}
 */
function renderEmpty(tableBody) {
    const emptyTemplate = document.getElementById('listing--empty');
    if (emptyTemplate === null) {
        return;
    }
    const emptyElement = emptyTemplate.content.cloneNode(true);
    tableBody.appendChild(emptyElement);
}

/**
 * @param {Element} tableBody 
 * @param {Array<any>} items
 * @return {void}
 */
function renderItems(tableBody, items) {
    const itemTemplate = document.getElementById('listing--item');
    if (itemTemplate === null) {
        return;
    }
    items.forEach(function (item) {
        let itemElement = itemTemplate.content.cloneNode(true);
        let itemId = itemElement.querySelector('.item__id--body');
        if (itemId !== null) {
            itemId.innerHTML = item.id;
        }
        tableBody.appendChild(itemElement);
    });
}

/**
 * @param {Element} fieldSet 
 * @param {any} details
 * @return {void}
 */
function renderDetails(fieldSet, details) {
    let id = fieldSet.getElementById('id');
    if (id !== null) {
        id.value = details.id;
    }
    let titulo = fieldSet.getElementById('titulo');
    if (titulo !== null) {
        titulo.value = details.titulo;
    }
    let listadorDeFrequenciaId = fieldSet.getElementById('listador_de_frequencia_id');
    if (listadorDeFrequenciaId !== null) {
        listadorDeFrequenciaId.value = details.listadorDeFrequenciaId;
    }
    let listadorDeFrequenciaType = fieldSet.getElementById('listador_de_frequencia_type');
    if (listadorDeFrequenciaType !== null) {
        listadorDeFrequenciaType.value = details.listadorDeFrequenciaType;
    }
    let dataDeLancamento = fieldSet.getElementById('data_de_lancamento');
    if (dataDeLancamento !== null) {
        dataDeLancamento.value = details.dataDeLancamento;
    }
}

window.addEventListener('load', handleLoad);
