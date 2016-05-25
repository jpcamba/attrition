<script>
    //User Values Chart
    var underload = {{json_encode($input['underload'])}};
    var regular = {{json_encode($input['regular'])}};
    var overload = {{json_encode($input['overload'])}};

    Morris.Donut({
        element: 'values',
        data: [
            {label: "Underload", value: underload},
            {label: "Regular", value: regular},
            {label: "Overload", value: overload}
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