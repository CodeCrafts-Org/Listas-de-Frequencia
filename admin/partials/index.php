<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>TÍTULO</th>
            <th>DATA DE LANÇAMENTO</th>
            <th>AÇÕES</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($paginated['items'] as $lista) {
        echo "
        <tr>
            <td>{$lista->getId()}</td>
            <td>{$lista->getTitulo()}</td>
            <td>{$lista->getDataDeLancamento()->format('Y-m-d')}</td>
            <td>aaaa</td>
        </tr>
        ";
    } ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="4">
                Paginação
            </td>
        </tr>
    </tfoot>
</table>