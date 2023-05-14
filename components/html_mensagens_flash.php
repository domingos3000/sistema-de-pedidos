<?php if(isset($mensagens)): ?>

<?php foreach($mensagens as $msg): ?>

    <div class="mensagens_animadas animate__animated animate__bounceInDown animate__delay-2s">
        <div>
            <p class="texto_mensagem">
                <?= $msg ?>
            </p>
            
            <button class="botao_fechar" onclick="this.parentElement.parentElement.remove();">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

<?php endforeach; ?>

<?php endif; ?>