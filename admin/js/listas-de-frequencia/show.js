/**
 * @param {Event} event 
 * @return {Promise<void>}
 */
async function handleDetailsLoad(event) {
    const container = document.querySelector('.lista-de-frequencia__details');
    if (container === null) {
        return;
    }
    const listaId = container.dataset.id;
    await handleDetailsFetch(listaId);
}

/**
 * @param {number} id
 * @return {Promise<void>}
 */
async function handleDetailsFetch(id) {
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
        renderDetailsError(frequenciasListing);
    } else if (details.frequencias.length === 0) {
        renderDetailsEmpty(frequenciasListing);
    } else {
        renderDetailsItems(frequenciasListing, details.frequencias);
    }
    renderDetails(listaData, details.listaDeFrequencia);
    return;
}

/**
 * @param {Element} tableBody 
 * @return {void}
 */
function renderDetailsError(tableBody) {
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
function renderDetailsEmpty(tableBody) {
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
function renderDetailsItems(tableBody, items) {
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
        let itemTitulo = itemElement.querySelector('.item__titulo--body');
        if (itemTitulo !== null) {
            itemTitulo.innerHTML = item.titulo;
        }
        let itemPresenca = itemElement.querySelector('.item__presenca--body');
        if (itemPresenca !== null) {
            itemPresenca.checked = item.estaPresente;
            itemPresenca.addEventListener('click', async function (event) {
                itemPresenca.disabled = true;
                const wordPressRestClient = new WordPressRestClient();
                const endpoint = `codecrafts/listas-de-frequencia/v1/frequencias/${item.id}/presenca`;
                let result = await wordPressRestClient.patch(endpoint, {
                    presenca: itemPresenca.checked
                });
                if (result === null || result.updated === false) {
                    itemPresenca.checked = !itemPresenca.checked;
                }
                itemPresenca.disabled = false;
            });
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
    let id = fieldSet.querySelector('#id');
    if (id !== null) {
        id.value = details.id;
    }
    let titulo = fieldSet.querySelector('#titulo');
    if (titulo !== null) {
        titulo.value = details.titulo;
    }
    let listadorDeFrequenciaId = fieldSet.querySelector('#listador_de_frequencia_id');
    if (listadorDeFrequenciaId !== null) {
        listadorDeFrequenciaId.value = details.parentId;
    }
    let listadorDeFrequenciaType = fieldSet.querySelector('#listador_de_frequencia_type');
    if (listadorDeFrequenciaType !== null) {
        listadorDeFrequenciaType.value = details.parentType;
    }
    let dataDeLancamento = fieldSet.querySelector('#data_de_lancamento');
    if (dataDeLancamento !== null) {
        const parsed = details.data.iso.split(/\D+/);
        const utc = Date.UTC(parsed[0], --parsed[1], parsed[2], parsed[3], parsed[4], parsed[5], parsed[6]);
        dataDeLancamento.valueAsDate = new Date(utc);
    }
}

window.addEventListener('load', handleDetailsLoad);
