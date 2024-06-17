<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<main class="main">
    <div class="module__description">
        <h1 card="module__title">
            <a href="?page=listas-de-frequencia">Listas de Frequência</a>
        </h1>
    </div>
    
    <div class="resource__toolbar">
        <h2 class="toolbar__context">Novo registro</h2>
    
        <div class="toolbar__buttons">
            <a class="toolbar__button" href="?page=listas-de-frequencia">Voltar para Listagem</a>
        </div>
    </div>
    
    <div class="resource__creation">
        <form method="post" id="lista_de_frequencia__form" class="lista_de_frequencia__form">
            <fieldset class="form--data">
                <legend>
                    Todos os campos são obrigatórios
                </legend>

                <div class="formgroup">
                    <label for="titulo">Título: </label>
                    <input type="text" id="titulo" placeholder="Insira um título para seu registro" />
                </div>
                <div class="formgroup">
                    <label for="listador_de_frequencia_id">Chave do Listador: </label>
                    <input type="text" id="listador_de_frequencia_id" placeholder="Insira um código único para seu Listador" />
                </div>
                <div class="formgroup">
                    <label for="listador_de_frequencia_type">Tipo do Listador: </label>
                    <input type="text" id="listador_de_frequencia_type" placeholder="Insira uma categoria para seu Listador" />
                </div>
                <div class="formgroup">
                    <label for="data_de_lancamento">Data de Lançamento: </label>
                    <input type="date" id="data_de_lancamento" />
                </div>
            </fieldset>

            <input class="lista_de_frequencia__form--submit" type="submit" value="Enviar" />
        </form>
    </div>
</main>
