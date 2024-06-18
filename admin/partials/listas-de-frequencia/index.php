<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<main class="main">
    <div class="module__description">
        <h1 card="module__title">
            <a href="?page=listas-de-frequencia">Listas de Frequência</a>
        </h1>
    </div>
    
    <div class="resource__toolbar">
        <h2 class="toolbar__context">Listagem</h2>
    
        <div class="toolbar__buttons">
            <a class="toolbar__button" href="?page=listas-de-frequencia-command">Adicionar Nova Lista</a>
        </div>
    </div>
    
    <div class="resource__listing listas-de-frequencia__listing">
        <table class="listing__table">
            <thead>
                <tr>
                    <th class="item__id--heading">ID</th>
                    <th class="item__titulo--heading">TÍTULO</th>
                    <th class="item__data--heading">DATA DE LANÇAMENTO</th>
                    <th class="item__acoes--heading">AÇÕES</th>
                </tr>
            </thead>
    
            <tbody class="listing__items">
            </tbody>

            <template id="listing--empty">
                <tr>
                    <td class="item--none" colspan="4">Não há registros cadastrados</td>
                </tr>
            </template>

            <template id="listing--error">
                <tr>
                    <td class="item--error" colspan="4">Algo inesperado ocorreu! Tente novamente</td>
                </tr>
            </template>

            <template id="listing--item">
                <tr>
                    <td class="item__id--body"></td>
                    <td class="item__titulo--body"></td>
                    <td class="item__data--body"></td>
                    <td class="item__acoes--body">
                        <div>
                            <a class="item--details">Detalhes</a>
                            <button class="item--delete">Excluir</button>
                        </div>
                    </td>
                </tr>
            </template>
    
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        </table>
    
        <div class="listing__pagination">
        </div>
    </div>
</main>
