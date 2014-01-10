Cariotaku Depoimento
===========================
Este plugin funciona em conjunto com o plugin Wordpress Form Manager e serve para visualização e administração de depoimentos.

Configuração
------------------------
Abra o arquivo *cariotaku-depoimento.php* e adicione os dados respectivos ao seu banco de dados
    
    $dep_table = array(
    	'table' => ''       //nome tabela
		,'nome' => ''       //nome do campo
		,'mensagem' => ''   //nome do campo
		,'evento' => ''     //nome do campo
		,'exibir' => ''     //nome do campo
	);

Shortcode
----------

    //Para visualizar os depoimentos de um determinado evento
    [depoimento evento="nome do evento"]
    
    //para visualizar todos os depoimentos recebidos
    [depoimento]
    
    
Adminitração de Depoimentos
------------------------------

Acesse os dados do formulário no Wordpress Form Manager, selecione o depoimento que deseja editar, no campo **exibir**:

-  **PARA AUTORIZAR DEPOIMENTO** - Acrescente a letra **'s'** (sem plics).

-  **PARA DESAUTORIZAR DEPOIMENTO** - Apague o conteúdo ou altere o conteúdo deste campo.