package com.example.neptun.controller;

import com.example.neptun.model.Course;
import com.example.neptun.model.User;
import com.example.neptun.repository.CourseRepository;
import com.example.neptun.repository.UserRepository;
import org.springframework.http.ResponseEntity;

import org.springframework.web.bind.annotation.*;

import java.util.Optional;



@RestController
@RequestMapping("/api/courses")
public class CourseController {
    private final CourseRepository courseRepository;
    private final UserRepository userRepository;

    public CourseController(CourseRepository courseRepository, UserRepository userRepository) {
        this.courseRepository = courseRepository;
        this.userRepository = userRepository;
    }

    @GetMapping
    public ResponseEntity<?> getAllCourses() {
        return ResponseEntity.ok(courseRepository.findAll());
    }

    public UserRepository getUserRepository() {
        return userRepository;
    }



    @PostMapping("/enroll/{courseId}")
    public ResponseEntity<?> enrollInCourse(
            @PathVariable Long courseId,
            @RequestParam String username
    ) {
        Optional<User> userOpt = userRepository.findByUsername(username);
        Optional<Course> courseOpt = courseRepository.findById(courseId);

        if (userOpt.isEmpty() || courseOpt.isEmpty()) {
            return ResponseEntity.badRequest().body("Invalid user or course ID");
        }

        User user = userOpt.get();
        Course course = courseOpt.get();

        if (!user.getRole().equals("STUDENT")) {
            return ResponseEntity.status(403).body("Only students can enroll in courses");
        }

        user.getEnrolledCourses().add(course);
        userRepository.save(user);

        return ResponseEntity.ok("Enrolled in course: " + course.getName());
    }

    public CourseRepository getCourseRepository() {
        return courseRepository;
    }
}
