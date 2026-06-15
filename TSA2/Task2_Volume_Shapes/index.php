<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 2 - Volume of Shapes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="grid-container">
    <div class="header">
        <h1>Volume of Shapes</h1>
    </div>

    <div class="main">
        <?php
        // User-defined functions
        function volumeCube($s)                    { return $s * $s * $s; }
        function volumeRectangularPrism($l, $w, $h){ return $l * $w * $h; }
        function volumePrism($b, $h, $len)         { return 0.5 * $b * $h * $len; }
        function volumeCylinder($r, $h)            { return M_PI * $r * $r * $h; }
        function volumePyramid($l, $w, $h)         { return (1/3) * $l * $w * $h; }
        function volumeCone($r, $h)                { return (1/3) * M_PI * $r * $r * $h; }
        function volumeSphere($r)                  { return (4/3) * M_PI * $r * $r * $r; }

        // Set variables
        $cube_s = 5;
        $cube_ans = volumeCube($cube_s);

        $rect_l = 6; $rect_w = 4; $rect_h = 3;
        $rect_ans = volumeRectangularPrism($rect_l, $rect_w, $rect_h);

        $prism_b = 4; $prism_h = 3; $prism_len = 10;
        $prism_ans = volumePrism($prism_b, $prism_h, $prism_len);

        $cyl_r = 5; $cyl_h = 10;
        $cyl_ans = round(volumeCylinder($cyl_r, $cyl_h), 2);

        $pyr_l = 6; $pyr_w = 4; $pyr_h = 9;
        $pyr_ans = volumePyramid($pyr_l, $pyr_w, $pyr_h);

        $cone_r = 5; $cone_h = 12;
        $cone_ans = round(volumeCone($cone_r, $cone_h), 2);

        $sphere_r = 7;
        $sphere_ans = round(volumeSphere($sphere_r), 2);
        ?>

        <!-- Cube -->
        <div class="shape-card">
            <table>
                <tr class="shape-title"><td colspan="3">Cube</td></tr>
                <tr class="col-header"><td>Values</td><td>Formula</td><td>Answer</td></tr>
                <tr>
                    <td>s = <?php echo $cube_s; ?></td>
                    <td class="formula">V = s<sup>3</sup></td>
                    <td class="answer"><?php echo $cube_ans; ?></td>
                </tr>
            </table>
        </div>

        <!-- Rectangular Prism -->
        <div class="shape-card">
            <table>
                <tr class="shape-title"><td colspan="3">Rectangular Prism</td></tr>
                <tr class="col-header"><td>Values</td><td>Formula</td><td>Answer</td></tr>
                <tr>
                    <td>l = <?php echo $rect_l; ?>, w = <?php echo $rect_w; ?>, h = <?php echo $rect_h; ?></td>
                    <td class="formula">V = l &times; w &times; h</td>
                    <td class="answer"><?php echo $rect_ans; ?></td>
                </tr>
            </table>
        </div>

        <!-- Triangular Prism -->
        <div class="shape-card">
            <table>
                <tr class="shape-title"><td colspan="3">Triangular Prism</td></tr>
                <tr class="col-header"><td>Values</td><td>Formula</td><td>Answer</td></tr>
                <tr>
                    <td>b = <?php echo $prism_b; ?>, h = <?php echo $prism_h; ?>, len = <?php echo $prism_len; ?></td>
                    <td class="formula">V = <sup>1</sup>&frasl;<sub>2</sub> &times; b &times; h &times; len</td>
                    <td class="answer"><?php echo $prism_ans; ?></td>
                </tr>
            </table>
        </div>

        <!-- Cylinder -->
        <div class="shape-card">
            <table>
                <tr class="shape-title"><td colspan="3">Cylinder</td></tr>
                <tr class="col-header"><td>Values</td><td>Formula</td><td>Answer</td></tr>
                <tr>
                    <td>r = <?php echo $cyl_r; ?>, h = <?php echo $cyl_h; ?></td>
                    <td class="formula">V = &pi;r<sup>2</sup>h</td>
                    <td class="answer"><?php echo $cyl_ans; ?></td>
                </tr>
            </table>
        </div>

        <!-- Pyramid -->
        <div class="shape-card">
            <table>
                <tr class="shape-title"><td colspan="3">Pyramid</td></tr>
                <tr class="col-header"><td>Values</td><td>Formula</td><td>Answer</td></tr>
                <tr>
                    <td>l = <?php echo $pyr_l; ?>, w = <?php echo $pyr_w; ?>, h = <?php echo $pyr_h; ?></td>
                    <td class="formula">V = <sup>1</sup>&frasl;<sub>3</sub> &times; l &times; w &times; h</td>
                    <td class="answer"><?php echo $pyr_ans; ?></td>
                </tr>
            </table>
        </div>

        <!-- Cone -->
        <div class="shape-card">
            <table>
                <tr class="shape-title"><td colspan="3">Cone</td></tr>
                <tr class="col-header"><td>Values</td><td>Formula</td><td>Answer</td></tr>
                <tr>
                    <td>r = <?php echo $cone_r; ?>, h = <?php echo $cone_h; ?></td>
                    <td class="formula">V = <sup>1</sup>&frasl;<sub>3</sub> &pi;r<sup>2</sup>h</td>
                    <td class="answer"><?php echo $cone_ans; ?></td>
                </tr>
            </table>
        </div>

        <!-- Sphere -->
        <div class="shape-card">
            <table>
                <tr class="shape-title"><td colspan="3">Sphere</td></tr>
                <tr class="col-header"><td>Values</td><td>Formula</td><td>Answer</td></tr>
                <tr>
                    <td>r = <?php echo $sphere_r; ?></td>
                    <td class="formula">V = <sup>4</sup>&frasl;<sub>3</sub> &pi;r<sup>3</sup></td>
                    <td class="answer"><?php echo $sphere_ans; ?></td>
                </tr>
            </table>
        </div>

    </div>

</div>

</body>
</html>
