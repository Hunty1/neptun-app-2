package com.example.neptun;

import com.example.neptun.controller.CourseController;
import com.example.neptun.model.Course;
import com.example.neptun.model.User;
import com.example.neptun.repository.CourseRepository;
import com.example.neptun.repository.UserRepository;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.http.ResponseEntity;

import static org.junit.jupiter.api.Assertions.*;

@SpringBootTest
public class CourseControllerTest {

    @Autowired
    private CourseController courseController;

    @Autowired
    private CourseRepository courseRepository;

    @Autowired
    private UserRepository userRepository;

    @BeforeEach
    public void setup() {
    
        User teacher = new User();
        teacher.setUsername("teacher1");
        teacher.setPassword("password");
        teacher.setRole("TEACHER");
        userRepository.save(teacher);

        Course course = new Course();
        course.setName("Matek");
        course.setCode("MATH101");
        course.setCredit(3);
        course.setTeacher(teacher);
        courseRepository.save(course);
    }

    @Test
    public void testGetAllCourses() {
        ResponseEntity<?> response = courseController.getAllCourses();
        assertNotNull(response.getBody());
        assertEquals(1, ((Iterable<?>) response.getBody()).spliterator().getExactSizeIfKnown());
    }

    @Test
    public void testEnrollInCourse() {
       
        User student = new User();
        student.setUsername("student1");
        student.setPassword("password");
        student.setRole("STUDENT");
        userRepository.save(student);

      
        ResponseEntity<?> response = courseController.enrollInCourse(1L, "student1");
        assertEquals(200, response.getStatusCodeValue());
    }
}
