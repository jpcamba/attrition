<script>
    //User Values Chart
    var luzon = {{json_encode($input['luzon'])}};
    var visayas = {{json_encode($input['visayas'])}};
    var mindanao = {{json_encode($input['mindanao'])}};

    Morris.Donut({
        element: 'values',
        data: [
            {label: "Luzon", value: luzon},
            {label: "Visayas", value: visayas},
            {label: "Mindanao", value: mindanao}
        ]
    });

    //Attrition Results Chart
    var attrition = {{json_encode($attrition)}};
    var retention = 100 - attrition;

    Morris.Donut({
        element: 'attrition',
        data: [
            {label: 'Attrition', value: attrition},
            {label: 'Retention', value: retention}
        ]
    });

</script>