<script>
    //User Values Chart
    var l1 = {{json_encode($input['lineof1'])}};
    var l2 = {{json_encode($input['lineof2'])}};
    var l3 = {{json_encode($input['lineof3'])}};
    var l4 = {{json_encode($input['lineof4'])}};

    Morris.Donut({
        element: 'values',
        data: [
            {label: "1.00-1.99", value: l1},
            {label: "2.00-2.99", value: l2},
            {label: "3.00-3.99", value: l3},
            {label: "4.00-5.00", value: l4}
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