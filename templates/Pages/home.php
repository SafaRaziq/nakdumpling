<?php
declare(strict_types=1);

/** @var \App\View\AppView $this */
/** @var iterable<\App\Model\Entity\MenuItem> $menuItems */
$this->disableAutoLayout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nak Dumpling | Sekali Cuba, Tak Cukup Satu</title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('ordering') ?>
</head>
<body>
    <header class="site-header">
        <div class="shell nav-row">
            <a class="brand" href="<?= $this->Url->build('/') ?>"><span class="brand-mark">NAK</span><span>Nak Dumpling</span></a>
            <nav aria-label="Main navigation"><a href="#menu">Menu</a><a href="#delivery">Delivery</a><a class="cart-link" href="#cart">Cart <span id="nav-cart-count">0</span></a></nav>
        </div>
    </header>
    <main>
        <section class="hero shell">
            <div class="hero-copy"><p class="eyebrow">Homemade dumplings • Since 2020</p><h1>Sekali cuba, tak cukup satu.</h1><p class="hero-intro">Soup, steam, fried, mee sua, party boxes and frozen dumplings made for sharing.</p><a class="button button-dark" href="#menu">Order sekarang <span aria-hidden="true">-&gt;</span></a></div>
            <div class="hero-art" aria-label="Illustration of a basket of dumplings" role="img"><span class="steam steam-one"></span><span class="steam steam-two"></span><span class="steam steam-three"></span><div class="bamboo-basket"><span></span><span></span><span></span><span></span></div></div>
        </section>
        <section class="order-layout shell" id="menu">
            <div class="menu-column">
                <div class="section-heading"><div><p class="eyebrow">Menu Nak Dumpling</p><h2>Pilih kegemaran anda</h2></div><span class="open-note"><span class="status-dot"></span> Open for orders</span></div>
                <div class="menu-grid">
                    <?php foreach ($menuItems as $item) : ?>
                        <article class="menu-item">
                            <div class="dish-image dish-<?= h((string)$item->id % 4) ?>">
                                <?php if (!empty($item->image)) : ?>
                                    <?= $this->Html->image($item->image, ['alt' => $item->name, 'class' => 'dish-photo']) ?>
                                <?php else : ?>
                                    <span class="dish-placeholder" aria-hidden="true">•••</span>
                                <?php endif; ?>
                            </div>
                            <div class="dish-details"><div class="dish-topline"><h3><?= h($item->name) ?></h3><strong>RM <?= number_format((float)$item->price, 2) ?></strong></div><p><?= h((string)$item->description) ?></p><button class="add-button" type="button" data-id="<?= h((string)$item->id) ?>" data-name="<?= h($item->name) ?>" data-price="<?= h((string)$item->price) ?>">Tambah <span aria-hidden="true">+</span></button></div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
            <aside class="cart-panel" id="cart"><div class="cart-heading"><div><p class="eyebrow">Your order</p><h2>Cart <span id="cart-count">(0)</span></h2></div><span class="cart-badge">Pickup or delivery</span></div><div class="cart-items" id="cart-items"><div class="empty-cart"><span class="empty-icon">+</span><p>Your cart is waiting.<br>Choose something delicious.</p></div></div><div class="cart-total"><span>Subtotal</span><strong id="cart-total">RM 0.00</strong></div><a class="button button-primary checkout-button" href="#delivery">Continue to details <span aria-hidden="true">-&gt;</span></a></aside>
        </section>
        <section class="delivery-section" id="delivery"><div class="shell delivery-grid"><div><p class="eyebrow">Hantar ke rumah anda</p><h2>Alamat penghantaran</h2><p class="muted">Letakkan pin lokasi dan maklumat rumah supaya rider kami mudah sampai.</p></div><form class="delivery-form" id="delivery-form"><label for="customer-name">Nama</label><input id="customer-name" name="name" required placeholder="Contoh: Dara Nak"><label for="customer-phone">No. telefon</label><input id="customer-phone" name="phone" required placeholder="Contoh: 012 345 678"><label for="customer-address">Alamat</label><input id="customer-address" name="address" required placeholder="Jalan, taman, mercu tanda"><div class="form-row"><div><label for="latitude">Latitude</label><input id="latitude" name="latitude" placeholder="Pin latitude"></div><div><label for="longitude">Longitude</label><input id="longitude" name="longitude" placeholder="Pin longitude"></div></div><label for="customer-details">Detail rumah</label><textarea id="customer-details" name="details" rows="3" placeholder="Warna pintu pagar, tingkat, atau arahan lain"></textarea><button class="button button-dark" type="submit">Teruskan pesanan <span aria-hidden="true">-&gt;</span></button><p class="form-message" id="form-message" role="status"></p></form></div></section>
        <section class="steps shell" id="how-it-works"><div><span>01</span><h3>Pilih</h3><p>Pilih menu dumpling kegemaran anda.</p></div><div><span>02</span><h3>Pin lokasi</h3><p>Berikan alamat yang jelas untuk penghantaran.</p></div><div><span>03</span><h3>Enjoy</h3><p>Kami masak, bungkus dan hantar.</p></div></section>
    </main>
    <footer class="site-footer"><div class="shell"><span>Nak Dumpling</span><span>Order: WhatsApp +014-230 0522</span></div></footer>
    <script>
        const cart = {};
        const money = value => `RM ${value.toFixed(2)}`;
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const cartCount = document.getElementById('cart-count');
        const navCartCount = document.getElementById('nav-cart-count');
        function renderCart() {
            const items = Object.values(cart);
            const count = items.reduce((sum, item) => sum + item.quantity, 0);
            const total = items.reduce((sum, item) => sum + item.price * item.quantity, 0);
            cartCount.textContent = `(${count})`;
            navCartCount.textContent = count;
            cartTotal.textContent = money(total);
            if (!items.length) { cartItems.innerHTML = '<div class="empty-cart"><span class="empty-icon">+</span><p>Your cart is waiting.<br>Choose something delicious.</p></div>'; return; }
            cartItems.innerHTML = items.map(item => `<div class="cart-item"><div><strong>${item.name}</strong><small>${money(item.price)} each</small></div><div class="quantity"><button type="button" data-action="decrease" data-id="${item.id}" aria-label="Remove one ${item.name}">-</button><span>${item.quantity}</span><button type="button" data-action="increase" data-id="${item.id}" aria-label="Add one ${item.name}">+</button></div></div>`).join('');
        }
        document.querySelectorAll('.add-button').forEach(button => button.addEventListener('click', () => { const { id, name, price } = button.dataset; cart[id] = cart[id] || { id, name, price: Number(price), quantity: 0 }; cart[id].quantity += 1; renderCart(); }));
        cartItems.addEventListener('click', event => { const button = event.target.closest('button'); if (!button) return; const item = cart[button.dataset.id]; item.quantity += button.dataset.action === 'increase' ? 1 : -1; if (item.quantity <= 0) delete cart[button.dataset.id]; renderCart(); });
        document.getElementById('delivery-form').addEventListener('submit', event => { event.preventDefault(); const message = document.getElementById('form-message'); message.textContent = Object.keys(cart).length ? 'Test order captured. The order endpoint will be connected next.' : 'Add at least one menu item before placing an order.'; message.className = 'form-message is-visible'; });
    </script>
</body>
</html>
