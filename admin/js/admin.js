class ListaDeFrequenciaCreationAsyncAction {
	#wordPressRestClient;
	#listaDeFrequenciaCreationSuccessObserver;
	#listaDeFrequenciaCreationFailureObserver;

	constructor(wordPressRestClient, listaDeFrequenciaCreationSuccessObserver, listaDeFrequenciaCreationFailureObserver) {
		this.#wordPressRestClient = wordPressRestClient;
		this.#listaDeFrequenciaCreationSuccessObserver = listaDeFrequenciaCreationSuccessObserver;
		this.#listaDeFrequenciaCreationFailureObserver = listaDeFrequenciaCreationFailureObserver;
	}

	async createListaDeFrequencia(titulo, listadorDeFrequenciaId, listadorDeFrequenciaType, dataDeLancamento) {
		let listaDeFrequencia = await this.#wordPressRestClient.post('codecrafts/listas-de-frequencia/v1/listas/create', {
			titulo: titulo,
			listador_de_frequencia_id: listadorDeFrequenciaId,
			listador_de_frequencia_type: listadorDeFrequenciaType,
			data_de_lancamento: dataDeLancamento
		});
		if (listaDeFrequencia !== null) {
			this.#listaDeFrequenciaCreationSuccessObserver.notify(listaDeFrequencia);
		} else {
			this.#listaDeFrequenciaCreationFailureObserver.notify(null);
		}

		return listaDeFrequencia;
	}
}

class WordPressRestClient {
	async post(endpoint, data) {
		try {
			let response = await fetch(`/wp-json/${endpoint}`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(data),
			});

			return response.json();
		} catch (error) {
			return null;
		}
	}

	async get(endpoint, params) {
		try {
			let response = await fetch(`/wp-json/${endpoint}?${params.join('&')}`, {
				method: 'GET',
				headers: {
					'Content-Type': 'application/json',
				},
			});

			return response.json();
		} catch (error) {
			return null;
		}
	}
}

class CreationDataSupplier {
	getLatestCreationData() {
		return {
			titulo: document.getElementById('titulo')?.value,
			listadorDeFrequenciaId: document.getElementById('listador_de_frequencia_id')?.value,
			listadorDeFrequenciaType: document.getElementById('listador_de_frequencia_type')?.value,
			dataDeLancamento: document.getElementById('data_de_lancamento')?.value,
		};
	}
}

class Observer {
	#listeners;

	constructor(listeners) {
		this.#listeners = listeners;
	}

	notify(event) {
		for (let listener of this.#listeners) {
			listener.handle(event);
		}
	}
}

class CreateListaDeFrequenciaCommand {
	#creationDataSupplier;
	#creationDataValidator;
	#listaDeFrequenciaCreationAsyncAction;

	constructor(creationDataSupplier, creationDataValidator, listaDeFrequenciaCreationAsyncAction) {
		this.#creationDataSupplier = creationDataSupplier;
		this.#creationDataValidator = creationDataValidator;
		this.#listaDeFrequenciaCreationAsyncAction = listaDeFrequenciaCreationAsyncAction;
	}

	handle(event) {
		let creationData = this.#creationDataSupplier.getLatestCreationData();
		let isValid = this.#creationDataValidator.validate(creationData);
		if (!isValid) {
			return;
		}
		this.#listaDeFrequenciaCreationAsyncAction.createListaDeFrequencia(
			creationData.titulo,
			creationData.listadorDeFrequenciaId,
			creationData.listadorDeFrequenciaType,
			creationData.dataDeLancamento
		);
	}
}

class CreationDataValidator {
	#creationDataValidationFailureObserver;

	constructor(creationDataValidationFailureObserver) {
		this.#creationDataValidationFailureObserver = creationDataValidationFailureObserver;
	}

	validate(creationData) {
		if (creationData.titulo === null || creationData.titulo.length === 0) {
			this.#creationDataValidationFailureObserver.notify('O título é obrigatório');
			return false;
		}
		if (creationData.titulo.length > 255) {
			this.#creationDataValidationFailureObserver.notify('O título não pode ultrapassar 255 caracteres');
			return false;
		}
		if (creationData.listadorDeFrequenciaId === null || creationData.listadorDeFrequenciaId.length === 0) {
			this.#creationDataValidationFailureObserver.notify('A chave do Listador é obrigatória');
			return false;
		}
		if (creationData.listadorDeFrequenciaId.length > 255) {
			this.#creationDataValidationFailureObserver.notify('A chave do Listador não pode ultrapassar 255 caracteres');
			return false;
		}
		if (creationData.listadorDeFrequenciaType === null || creationData.listadorDeFrequenciaType.length === 0) {
			this.#creationDataValidationFailureObserver.notify('O tipo do Listador é obrigatório');
			return false;
		}
		if (creationData.listadorDeFrequenciaType.length > 255) {
			this.#creationDataValidationFailureObserver.notify('O tipo do Listador não pode ultrapassar 255 caracteres');
			return false;
		}
		if (creationData.dataDeLancamento === null || creationData.dataDeLancamento.length === 0) {
			this.#creationDataValidationFailureObserver.notify('A data de lançamento é obrigatória');
			return false;
		}

		return true;
	}
}

class AlertMessage {
	handle(message) {
		alert(message);
	}
}

class RedirectToDetails {
	handle(event) {
		window.location.replace('/wp-admin/admin.php?page=listas-de-frequencia');
	}
}

window.addEventListener('load', function (loadEvent) {
	let creationDataValidationFailureObserver = new Observer([
		new AlertMessage
	]);
	let creationDataValidator = new CreationDataValidator(
		creationDataValidationFailureObserver
	);
	let listaDeFrequenciaCreationSuccessObserver = new Observer([
		{ handle: (event) => alert('Registro criado com sucesso!') },
		new RedirectToDetails
	]);
	let listaDeFrequenciaCreationFailureObserver = new Observer([
		{ handle: (event) => alert('Algo de errado aconteceu, por favor tente novamente mais tarde') }
	]);
	let listaDeFrequenciaCreationAsyncAction = new ListaDeFrequenciaCreationAsyncAction(
		new WordPressRestClient,
		listaDeFrequenciaCreationSuccessObserver,
		listaDeFrequenciaCreationFailureObserver
	);
	let createListaDeFrequenciaCommand = new CreateListaDeFrequenciaCommand(
		new CreationDataSupplier,
		creationDataValidator,
		listaDeFrequenciaCreationAsyncAction
	);
	let listaDeFrequenciaFormSubmissionObserver = new Observer([
		createListaDeFrequenciaCommand
	]);
	document.getElementById('lista_de_frequencia__form')?.addEventListener('submit', function (submitEvent) {
		submitEvent.preventDefault();
		listaDeFrequenciaFormSubmissionObserver.notify(submitEvent);
	});
})
