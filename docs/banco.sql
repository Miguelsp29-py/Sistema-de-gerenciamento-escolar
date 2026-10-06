DROP DATABASE IF EXISTS `SistemaUniversitario`;

CREATE DATABASE SistemaUniversitario;
USE SistemaUniversitario;

CREATE TABLE Curso(
id_curso INT PRIMARY KEY,
nomeCurso VARCHAR(255) NOT NULL
);

CREATE TABLE Aluno(
id_aluno INT PRIMARY KEY,
nomeAluno VARCHAR(255) NOT NULL,
id_curso INT,
FOREIGN KEY (id_curso) REFERENCES Curso(id_curso)
);

CREATE TABLE Professor(
id_professor INT PRIMARY KEY,
nomeProfessor VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
senha VARCHAR(255) NOT NULL
);

CREATE TABLE Disciplina(
id_disciplina INT PRIMARY KEY,
nomeDisciplina VARCHAR(255) NOT NULL,
id_curso INT,
id_professor INT,
mediaDefinida INT,
FOREIGN KEY (id_curso) REFERENCES Curso(id_curso),
FOREIGN KEY (id_professor) REFERENCES Professor(id_professor)
);

CREATE TABLE Boletim(
id_boletim INT PRIMARY KEY,
nota FLOAT,
frequencia FLOAT,
situacao VARCHAR(255),
id_aluno INT,
id_disciplina INT,
FOREIGN KEY (id_aluno) REFERENCES Aluno(id_aluno),
FOREIGN KEY (id_disciplina) REFERENCES Disciplina(id_disciplina)
);

INSERT INTO Curso VALUES
(1,"Informatica"),
(2,"AnalisesClinicas"),
(3,"ADM"),
(4,"Eletronica");

INSERT INTO Aluno VALUES
(1,"Henrique",1),
(2,"Victor",1),
(3,"Miguel",2),
(4,"Brunao",4),
(5,"Bruninho",3);

INSERT INTO Professor VALUES
#(1,"Vitao","vitao@escola.com","Vitao123"),
(1,"Vitao","vitao@escola.com","$2y$12$NiRD96/L7gEbH9E5rlMA5.1xdW50.VV/amKj5XFv.RyZVHafZaCYK"),

#(2,"Alberson","alberson@escola.com","Alberson123"),
(2,"Alberson","alberson@escola.com","$2y$10$p2fAonWSV75/z9Vo/Rzng./7jjNmxvCRKRGPY90ObKcL8sak6yTJ."),

#(3,"Wagner","wagner@escola.com","Wagner123"),
(3,"Wagner","wagner@escola.com","$2y$10$1agwNgpNJhbijtSPk7yu1.JW1hnLSgjRZ5Kb0OZk6kgugd/VcZa5e"),

#(4,"Helio","helio@escola.com","Helio123"),
(4,"Helio","helio@escola.com","$2y$10$IaQpFOxSmDtMRh1QQ/B8w.XzkkviyR.m37nk8cCeV8kL3iQ5dBiC2"),

#(5,"Alguem","alguem@escola.com","Alguem123");
(5,"Alguem","alguem@escola.com","$2y$10$gKsqHijc1InfP4XtXSVtVOU1C.ArjSD1SACahOhM25i5C30hhXFoK");

INSERT INTO Disciplina VALUES
(1,"POO",1,1,7),
(2,"PVB",1,2,7),
(3,"PAW",1,3,7),
(4,"Biologia",2,4,5),
(5,"ASV",2,5,5),
(6,"Administração de empresas",3,1,6),
(7,"Arduino",4,2,6);

INSERT INTO Boletim VALUES
(1, 10, 95, "Acima da média", 1, 1),
(2, 8.5, 90, "Acima da média", 2, 1),
(3, 10, 98, "Acima da média", 3, 2),
(4, 5, 67, "Abaixo da média", 4, 4),
(5, 4.5, 60, "Abaixo da média", 5, 3);