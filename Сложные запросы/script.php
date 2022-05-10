<?php

$pdo = new PDO("mysql:host=localhost;dbname=students;", "r1", "xxxx");

$sql = "select id from students group by id order by id asc;";
$query = $pdo->prepare($sql);
$query->execute();
$id_students = $query->fetchAll();	// Считал id учащихся студентов

//var_dump($id_students);

$sql = "SELECT date as day_of_classes, sj.id as sj_id from subject_schedules as ss JOIN subjects as sj ON sj.id = ss.subject_id ORDER BY date ASC LIMIT 100;";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll();	// Считал расписание (дата, дисциплина)

//var_dump($data);

$sql = "INSERT INTO `student_presents` (`student_id`, `subject_id`, `date`, `attendance`) VALUES (:student_id, :subject_id, :date, :attendance)";

for ($z = 0; $z < count($data); ++$z)	// Итерации по каждой дисциплине в день
{
	for($count_s = 0; $count_s < count($id_students); ++$count_s)	// Итерации по студентам
	{
		$query = $pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

		$query->execute(array(':student_id' => $id_students[$count_s][0], ':subject_id' => $data[$z]['sj_id'], ':date' => $data[$z]['day_of_classes'], ':attendance' => rand(0,1)));
	}
}

?>