<?php

return [
    'alipay' => [
        'app_id'         => '2016092000554679',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAhhZN0+kd/s6z85fgE8yE61aib6yXCHybPVZNH8rXDMwa0P60C5aV372U2FUTn2Yj91TcgjMwM/MtUj8EKBEgURx0rj1F0CTFqLf6M+8lXoxIPMdN7+dCnnhNQl16OULPOOZuDiTdTEDUsPG0PLiEcWsIkIU6fnMNtQBuMSAVQ1qqWPSbqUUC9shyWJEYOZQ2LktS5RFuwBgso/MWL4oHnspZI8hk68WQuJ/Sjx+wjRVqaRCYrcZPLXejlCFj7PHcoCuyK3OHmtIRr/8ZhYgnXAqdICLYJnDf/TDkDftI/evo14nge2EdSTakzt5L+prJ5yJkXu/6evx/ciDshxgaOQIDAQAB',
        'private_key'    => 'MIIEowIBAAKCAQEAhhZN0+kd/s6z85fgE8yE61aib6yXCHybPVZNH8rXDMwa0P60C5aV372U2FUTn2Yj91TcgjMwM/MtUj8EKBEgURx0rj1F0CTFqLf6M+8lXoxIPMdN7+dCnnhNQl16OULPOOZuDiTdTEDUsPG0PLiEcWsIkIU6fnMNtQBuMSAVQ1qqWPSbqUUC9shyWJEYOZQ2LktS5RFuwBgso/MWL4oHnspZI8hk68WQuJ/Sjx+wjRVqaRCYrcZPLXejlCFj7PHcoCuyK3OHmtIRr/8ZhYgnXAqdICLYJnDf/TDkDftI/evo14nge2EdSTakzt5L+prJ5yJkXu/6evx/ciDshxgaOQIDAQABAoIBADH8vqbxkS0dAhkd1XuME0Fo2sWnIecYDQeg1L+1btZmgNjJG3X2fYkbtBGyJc6W1XGvQUWIr7+uOIcg1vvY5qNWaGlMjmo6SzXK4Ivb66KDyape4r89B6jsUGEdWCNgtMARp5W+SIHU6XXNpdO9NiLSNC8se9IIMmP39Rx7SXICHECekku+a+mNwqN9j8j7HZ+ATqOV5w6pfy5wFIh3LoYcgKKfZ4CTYPnkCdX56rGnHvWwFRnfzYupakhPUwB9RWjRlmx4hv2ppQRqu3OzCUh2TIkcuiAMdk5RPbbDcYvgWz6m5064klazbM3c51GLCcUcregFCHtL22npLGjMpsECgYEA7tgNsbdSciOQf10U0L9GAy14ba6oykID7HipBRu2t+30jsZLNO8eXNuU2MeNtu7k3FGRMFXZ5SOmmeHBbD/sTmRAnvZMvksgE4L3wxXMwi+aFhRR5v0+Eg+0pg72+gbD7XIdCd9KMmoWU9Ayfm8tTaSa1y1aFu3ErcetDKYJbNcCgYEAj7fx8rjweUVJQcOoAFN23mWaP96uReQA/l4YPmu36UkczY9HxNwD5W6tY3YNsWha9rz6LmZ1I1aG3+8he8kEJxDtQyzynHvyrWOvUsO9cEkcppIBhrzUBCIMS1L/MSGNKtnrLubcu28+dNuyyjU7PWPS9kKnp4ej4d4KW2pvP28CgYEAkRWI7AVR/aeA5P0j4dHus4txdh78xS/otkJtWX8GNSBEyF3H3XXLWdjAyBYgDZl8SCD8MwJThA9t6lfqaNlDsDLR1j4DTCzSZUfPPSAG64aC8RqSzd/TTqFfuOeqOyLU7W2+GfsbVRiAS5VStt7OBDYTINaZvQfdyzpZ8i8B1q0CgYAaOs8spnY1G+Ef4I6z6IfEVTTOvVx/IvrPcero0Y4SRKa+GY1Wr3UCla2NfolHPK2FZL4gY9CzL2KUUjeBORHJ83vqC7UHvFNxM8VWzKSxbpaNDA69QY9MZc5qnO44UFBMZtNWjwnwJ4B1oXdDEm4KaUKicU3Z9JaDbZvkTUuafwKBgHVVBbrGmHUihZPye9IclzFfLxhsLoS3MCitFe84KD9ZLLkaGsnbmObFTMvBQSLqW+6cAWIXAuWPJ3tCwNmQImxRr+I0diEmoy7+ur5pKy2lmKbCoILgL0sD8mO48SBL5gt/ksgK6XBLQHEfWBEdUH7J3mGA0UETSNFNfC9lCLcs',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ],
    ],

    'wechat' => [
        'app_id'      => '',
        'mch_id'      => '',
        'key'         => '',
        'cert_client' => '',
        'cert_key'    => '',
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];
