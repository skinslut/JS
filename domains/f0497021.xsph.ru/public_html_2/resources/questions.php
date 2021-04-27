<?
return [
    [
        [
            'text' => 'Свойство объекта XmlHttpRequest readyState – это...',
            'answers' => ['Cостояние готовности', 'Cостояние завершенности', 'Cостояние настройки'],
            'answer' => 'Cостояние готовности'
        ],
        [
            'text' => 'Событие onreadystatechange – это событие объекта...',
            'answers' => ['XMLHttpRequest', 'XMLHttpAJAX', 'XMLHttpReadyState'],
            'answer' => 'XMLHttpRequest'
        ],
        [
            'text' => 'Выберите значения свойства readyState в нужном порядке',
            'answers' => [
            'Запрос не инициализирован -> выполнена настройка запроса -> запрос отправлен -> запрос находится в процессе обработки на сервере -> запрос завершён.',
            'Запрос отправлен -> запрос находится в процессе обработки на сервере -> запрос не инициализирован -> выполнена настройка запроса -> запрос завершён.',
            'Выполнена настройка запроса -> запрос не инициализирован -> запрос отправлен -> запрос находится в процессе обработки на сервере -> запрос завершён.'
        ],
            'answer' => 'Запрос не инициализирован -> выполнена настройка запроса -> запрос отправлен -> запрос находится в процессе обработки на сервере -> запрос завершён.'
        ],
        [
            'text' => 'Событие onreadystatechange – это событие объекта...',
            'answers' => ['XMLHttpRequest', 'XMLHttpAJAX', 'XMLHttpReadyState'],
            'answer' => 'XMLHttpRequest'
        ],
        [
            'text' => 'Событие onreadystatechange используется для того, чтобы',
            'answers' => ['определить на какой стадии находится запрос', 'отправить запрос на сервер', 'выполнить настройку запроса.'],
            'answer' => 'набор технологий для асинхронных запросов'
        ],
        [
            'text' => 'AJAX – это...',
            'answers' => ['набор технологий для асинхронных запросов', 'язык программирования', 'разрешение языка JS'],
            'answer' => 'набор технологий для асинхронных запросов'
        ],
        [
            'text' => 'Если есть два асинхронных вызова, где первому нужно время, то...',
            'answers' => [
            'первый вызов начнет запуск в фоновом режиме, позволяя второму вызову запуститься без ожидания',
            'второй вызов не начнет запуск, пока не завершится первый',
            'первый вызов начнет или не начнет запуск в фоновом режиме в зависимости от того, сколько времени понадобиться'
        ],
            'answer' => 'первый вызов начнет запуск в фоновом режиме, позволяя второму вызову запуститься без ожидания'
        ],
        [
            'text' => 'Еvent loop – это...',
            'answers' => [
            'цикл обработки событий',
            'цикл обработки информации',
            'цикл хранения информации'
        ],
            'answer' => 'цикл обработки событий'
        ],
        [
            'text' => 'Цикл еventLoop отвечает за...',
            'answers' => [
            'выполнение кода, сбор и обработку событий и выполнения подзадач из очереди',
            'выполнение кода, сбор и обработку информации',
            'сбор и хранение информации'
        ],
            'answer' => 'выполнение кода, сбор и обработку событий и выполнения подзадач из очереди'
        ],
        [
            'text' => 'Web API представляет собой...',
            'answers' => [
            'программный интерфейс приложения',
            'пользовательский интерфейс приложения',
            'графический интерфейс пользователя'
        ],
            'answer' => 'выполнение кода, сбор и обработку событий и выполнения подзадач из очереди'
        ],
        [
            'text' => 'Web API – это...',
            'answers' => [
            'описание способов (набор классов, процедур, функций, структур или констант), которыми одна компьютерная программа может взаимодействовать с другой программой',
            'описание способов (набор классов, процедур, функций, структур или констант), благодаря которыми программный продукт может хранить и обрабатывать информацию',
            'цикл обработки событий, благодаря которому выполняется код, происходит сбор и обработка событий, а также выполняются подзадачи из очереди'
        ],
            'answer' => 'описание способов (набор классов, процедур, функций, структур или констант), которыми одна компьютерная программа может взаимодействовать с другой программой'
        ]
    ],
    [
        [
            'text' => 'Cколько состояний имеет промис?',
            'answers' => ['Одно', 'Три', 'Пять'],
            'answer' => 'Три'
        ],
        [
            'text' => 'Состояния промиса:',
            'answers' => ['промис в состоянии ожидания, промис решен, промис отклонен', 'промис в состоянии ожидания, в состоянии обработки, в состоянии завершения', 'промис в состоянии инициализации, в состоянии настройки, в состоянии готовности'],
            'answer' => 'промис в состоянии ожидания, промис решен, промис отклонен'
        ],
        [
            'text' => 'Когда мы вызываем resolve и reject в функции промиса?',
            'answers' => ['resolve при решении промиса и reject при его отклонении', 'reject при решении промиса и resolve при его отклонении', 'resolve, как и reject, может вызываться и при решении, и при отклонении'],
            'answer' => 'resolve при решении промиса и reject при его отклонении'
        ],
        [
            'text' => 'Промисы используются тогда, когда выполняем:',
            'answers' => ['синхронные запросы', 'асинхронные запросы', 'синхронные и асинхронные запросы'],
            'answer' => 'асинхронные запросы'
        ],
        [
            'text' => 'Промис – это объект, который дает возможность описать, как...',
            'answers' => ['работать с данными, которые еще не появились в программе', 'отследить ошибки, которые могут появиться', 'моделировать множество запросов в виде одного объекта'],
            'answer' => 'работать с данными, которые еще не появились в программе'
        ],
        [
            'text' => 'Конструкции future, promise и delay формируют стратегию вычисления, применяемую для ...',
            'answers' => ['параллельных вычислений', 'последовательных вычислений', 'параллельных и последовательных вычислений'],
            'answer' => 'работать с данными, которые еще не появились в программе'
        ],
        [
            'text' => 'С помощью future, promise и delay описывается объект, к которому можно обратиться за результатом, вычисление которого...',
            'answers' => ['может быть не завершено на данный момент', 'обязательно должно быть завершено'],
            'answer' => 'может быть не завершено на данный момент'
        ],
        [
            'text' => 'Доступные свойства промиса для назначения коллбэков называтюся...',
            'answers' => ['onFulfilled, onRejected', 'onBad, onDone', 'onSuccess, onResolved'],
            'answer' => 'onFulfilled, onRejected'
        ],
        [
            'text' => 'Колбэк типа onFulfilled срабатывает тогда, когда промис в состоянии...',
            'answers' => ['«выполнен успешно»', '«выполнен с ошибкой»'],
            'answer' => '«выполнен успешно»'
        ],
        [
            'text' => 'Колбэк промиса типа onRejected срабатывает тогда, когда промис в состоянии...',
            'answers' => ['«выполнен успешно»', '«выполнен с ошибкой»'],
            'answer' => '«выполнен с ошибкой»'
        ]
    ]
];