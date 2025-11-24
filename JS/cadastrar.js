function carregarCidades(cidadePreSelecionada = null) {
    const estado = document.getElementById('estado').value;
    const selectCidade = document.getElementById('cidade');
    
    selectCidade.innerHTML = '<option value="">Carregando...</option>';
    selectCidade.disabled = true;

    if (!estado) {
        selectCidade.innerHTML = '<option value="">Selecione um estado primeiro</option>';
        return;
    }

    fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estado}/municipios?orderBy=nome`)
        .then(res => {
            if (!res.ok) throw new Error('Erro ao consultar a API do IBGE');
            return res.json();
        })
        .then(cidades => {
            selectCidade.innerHTML = '<option value="">Selecione uma Cidade</option>';
            
            cidades.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.nome;
                opt.textContent = c.nome;

                // AQUI ESTÁ O TRUQUE: 
                // Se a cidade atual do loop for igual a que veio do banco, seleciona ela
                if (cidadePreSelecionada && c.nome === cidadePreSelecionada) {
                    opt.selected = true;
                }

                selectCidade.appendChild(opt);
            });
            
            selectCidade.disabled = false;
        })
        .catch(err => {
            console.error(err);
            selectCidade.innerHTML = '<option value="">Erro ao carregar</option>';
        });
}

document.addEventListener("DOMContentLoaded", () => {
    const estadoInicial = document.getElementById('estado').value;
    const cidadeDoBanco = "<?= $usuario['cidade'] ?>"; 
    if (estadoInicial) {
        carregarCidades(cidadeDoBanco);
    }
});