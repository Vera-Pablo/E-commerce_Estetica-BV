<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Venta #<?= esc($venta['id_venta']) ?></title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333333;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0 0 5px 0;
            color: #1a202c;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 0;
            color: #718096;
            font-size: 13px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            padding: 5px 0;
        }
        .box {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
        }
        .box-title {
            font-size: 11px;
            font-weight: bold;
            color: #718096;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .box-content {
            font-size: 13px;
            font-weight: bold;
            color: #2d3748;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #edf2f7;
            color: #4a5568;
            font-size: 11px;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #cbd5e0;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .totals-table {
            width: 40%;
            margin-left: auto;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .totals-table td {
            padding: 6px 10px;
        }
        .total-row {
            font-size: 16px;
            font-weight: bold;
            color: #2b6cb0;
            border-top: 2px solid #cbd5e0;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            color: #a0aec0;
            font-size: 11px;
            font-style: italic;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            background-color: #e2e8f0;
            color: #2d3748;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="<?= FCPATH . 'assets/images/logos/Logo-BV.webp' ?>" height="45" style="max-height: 50px; width: auto; margin-bottom: 5px;" alt="Estética BV">
        <p>Comprobante de Venta Oficial</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 48%; padding-right: 2%;">
                <div class="box">
                    <div class="box-title">Datos del Cliente</div>
                    <div class="box-content"><?= esc($venta['apellido_nombre'] ?? '—') ?></div>
                    <div style="font-size: 11px; color: #4a5568; margin-top: 4px;">
                        <strong>DNI:</strong> <?= esc($venta['dni'] ?? '—') ?><br>
                        <strong>Email:</strong> <?= esc($venta['email'] ?? '—') ?>
                    </div>
                </div>
            </td>
            <td style="width: 48%; padding-left: 2%;">
                <div class="box">
                    <div class="box-title">Detalles del Comprobante</div>
                    <div class="box-content">Comprobante #<?= esc($venta['id_venta']) ?></div>
                    <div style="font-size: 11px; color: #4a5568; margin-top: 4px;">
                        <strong>Fecha de Emisión:</strong> <?= esc($venta['fecha_venta']) ?><br>
                        <strong>Estado:</strong> <?= esc($venta['nombre_estado'] ?? 'Indefinido') ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="info-table" style="margin-bottom: 25px;">
        <tr>
            <td style="width: 48%; padding-right: 2%;">
                <div class="box">
                    <div class="box-title">Método de Pago</div>
                    <div class="box-content"><?= esc($venta['nombre_metodo_pago'] ?? '—') ?></div>
                </div>
            </td>
            <td style="width: 48%; padding-left: 2%;">
                <div class="box">
                    <div class="box-title">Tipo de Entrega</div>
                    <div class="box-content"><?= esc($venta['tipo_entrega'] ?? 'Retiro en local') ?></div>
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-center" style="width: 15%;">Cantidad</th>
                <th class="text-right" style="width: 20%;">Precio Unit.</th>
                <th class="text-right" style="width: 20%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($detalles)): ?>
                <?php foreach ($detalles as $item): ?>
                    <tr>
                        <td><?= esc($item['nombre_producto'] ?? '—') ?></td>
                        <td class="text-center"><?= (int)$item['cantidad'] ?></td>
                        <td class="text-right">$<?= number_format((float)$item['precio_unitario'], 2, ',', '.') ?></td>
                        <td class="text-right">$<?= number_format((float)$item['subtotal'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center" style="color: #718096;">Sin ítems registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="totals-table">
        <tr class="total-row">
            <td>Total</td>
            <td class="text-right">$<?= number_format((float)$venta['total'], 2, ',', '.') ?></td>
        </tr>
    </table>

    <div class="footer">
        <p>Gracias por su compra en Estética BV.<br>Este documento es un comprobante válido de su transacción.</p>
    </div>

</body>
</html>
