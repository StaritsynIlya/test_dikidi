-- запрос исключающий снятых с производства мотоциклов и выводящий все типы всегда
SELECT tm.name as 'тип мотоцикла', count(m.id) as 'кол-во' FROM test_dikidi.types_motorcycles as tm
left join test_dikidi.motorcycles as m on m.type_id = tm.id AND m.discontinued != true
group by tm.name;