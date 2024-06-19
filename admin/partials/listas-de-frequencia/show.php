<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<main class="main lista-de-frequencia__details" data-id="<?= $listaId ?>">
    <div class="module__description">
        <h1 card="module__title">
            <a href="?page=listas-de-frequencia">Listas de Frequência</a>
        </h1>
    </div>
    
    <div class="resource__toolbar">
        <h2 class="toolbar__context">Detalhes do registro #<?= $listaId ?></h2>
    
        <div class="toolbar__buttons">
            <a class="toolbar__button" href="?page=listas-de-frequencia-command">Adicionar Nova Lista</a>
            <a class="toolbar__button" href="?page=listas-de-frequencia">Voltar para Listagem</a>
        </div>
    </div>
    
    <div class="resource__creation lista-de-frequencia__data">
        <form>
            <fieldset class="form--data" disabled>
                <div class="formgroup">
                    <label for="id">ID: </label>
                    <input type="text" id="id" />
                </div>
                <div class="formgroup">
                    <label for="titulo">Título: </label>
                    <input type="text" id="titulo" />
                </div>
                <div class="formgroup">
                    <label for="listador_de_frequencia_id">Chave do Listador: </label>
                    <input type="text" id="listador_de_frequencia_id" />
                </div>
                <div class="formgroup">
                    <label for="listador_de_frequencia_type">Tipo do Listador: </label>
                    <input type="text" id="listador_de_frequencia_type" />
                </div>
                <div class="formgroup">
                    <label for="data_de_lancamento">Data de Lançamento: </label>
                    <input type="date" id="data_de_lancamento" />
                </div>
            </fieldset>
        </form>
    </div>
    
    <div class="resource__listing frequencias__listing">
        <table class="listing__table">
            <thead>
                <tr>
                    <th class="item__id--heading">ID</th>
                </tr>
            </thead>
    
            <tbody class="listing__items">
            </tbody>

            <template id="listing--error">
                <tr>
                    <td class="item--error" colspan="1">Algo inesperado ocorreu! Tente novamente</td>
                </tr>
            </template>

            <template id="listing--empty">
                <tr>
                    <td class="item--none" colspan="1">Não há frequências cadastradas</td>
                </tr>
            </template>

            <template id="listing--item">
                <tr>
                    <td class="item__id--body"></td>
                </tr>
            </template>
    
            <tfoot>
                <tr>
                    <td colspan="1"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</main>
