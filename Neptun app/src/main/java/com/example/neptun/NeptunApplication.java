package com.example.neptun;

import com.example.neptun.model.Course;
import com.example.neptun.model.User;
import com.example.neptun.repository.CourseRepository;
import com.example.neptun.repository.UserRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

@SpringBootApplication
public class NeptunApplication {
	public static void main(String[] args) {
		SpringApplication.run(NeptunApplication.class, args);
	}

	CommandLineRunner initDatabase(UserRepository userRepository, CourseRepository courseRepository) {
		return args -> {
			User teacher = new User();
			teacher.setUsername("teacher1");
			teacher.setPassword("password");
			teacher.setRole("TEACHER");
			userRepository.save(teacher);

			User student = new User();
			student.setUsername("student1");
			student.setPassword("password");
			student.setRole("STUDENT");
			userRepository.save(student);

			Course math = new Course();
			math.setName("Matek");
			math.setCode("MATH101");
			math.setCredit(3);
			math.setTeacher(teacher);

			Course pe = new Course();
			pe.setName("Tesi");
			pe.setCode("PE101");
			pe.setCredit(2);
			pe.setTeacher(teacher);

			courseRepository.save(math);
			courseRepository.save(pe);
		};
	}
}
