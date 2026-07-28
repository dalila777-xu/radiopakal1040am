<?php
$noticias = [
    [
        'titulo' => 'Nueva programación en Radio Pakal 104.0',
        'descripcion' => 'Descubre los nuevos programas y horarios de la semana.',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+1'
    ],
    [
        'titulo' => 'Evento especial con la comunidad',
        'descripcion' => 'Conoce la próxima actividad cultural organizada por la radio.',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+2'
    ],
    [
        'titulo' => 'Entrevista exclusiva',
        'descripcion' => 'Escucha la conversación con nuestros invitados especiales.',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+3'
    ]
];
?>

<section class="noticias">
    <h2>Noticias</h2>
    <div class="lista-noticias">
        <?php foreach ($noticias as $noticia): ?>
            <article class="noticia">
                <img src="<?= htmlspecialchars($noticia['imagen']) ?>" alt="<?= htmlspecialchars($noticia['titulo']) ?>" width="150" height="100">
                <div class="contenido">
                    <h3><?= htmlspecialchars($noticia['titulo']) ?></h3>
                    <p><?= htmlspecialchars($noticia['descripcion']) ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<style>
.noticias {
    font-family: Arial, sans-serif;
    margin: 20px 0;
}

.lista-noticias {
    display: grid;
    gap: 15px;
}

.noticia {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
}

.noticia img {
    border-radius: 6px;
    object-fit: cover;
}

.contenido h3 {
    margin: 0 0 5px;
    font-size: 18px;
}

.contenido p {
    margin: 0;
    color: #555;
}
</style>
