<script>
    //User Values Chart
    var nd = {{json_encode($input['nd'])}};
    var pd33 = {{json_encode($input['pd33'])}};
    var pd60 = {{json_encode($input['pd60'])}};
    var pd80 = {{json_encode($input['pd80'])}};
    var fd = {{json_encode($input['fd'])}};
    var fds = {{json_encode($input['fds'])}};

    Morris.Donut({
        element: 'values',
        data: [
            {label: "No Discount (A)", value: nd},
            {label: "PD 33% (B)", value: pd33},
            {label: "PD 60% (C)", value: pd60},
            {label: "PD 80% (D)", value: pd80},
            {label: "Full Discount (E1)", value: fd},
            {label: "Full Discount with Stipend (E2)", value: fds},
        ]
    });

    //Attrition Results Chart
    var attrition = {{json_encode($attrition)}};
    var retention = 100 - attrition;
    retention = Math.round((retention + 0.00001) * 100) / 100;

    Morris.Donut({
        element: 'attrition',
        data: [
            {label: 'Attrition', value: attrition},
            {label: 'Retention', value: retention}
        ]
    });

</script>