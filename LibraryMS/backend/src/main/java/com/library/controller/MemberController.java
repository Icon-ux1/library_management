package com.library.controller;

import com.library.model.Member;
import com.library.service.MemberService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/members")
public class MemberController {
    @Autowired
    private MemberService memberService;

    @GetMapping
    public ResponseEntity<List<Member>> getAllMembers() {
        return ResponseEntity.ok(memberService.getAllMembers());
    }

    @GetMapping("/{id}")
    public ResponseEntity<Member> getMemberById(@PathVariable Integer id) {
        Optional<Member> member = memberService.getMemberById(id);
        return member.map(ResponseEntity::ok).orElseGet(() -> ResponseEntity.notFound().build());
    }

    @PostMapping
    public ResponseEntity<Member> createMember(@RequestBody Member member) {
        return ResponseEntity.ok(memberService.saveMember(member));
    }

    @PutMapping("/{id}")
    public ResponseEntity<Member> updateMember(@PathVariable Integer id, @RequestBody Member member) {
        Optional<Member> existing = memberService.getMemberById(id);
        if (existing.isPresent()) {
            member.setId(id);
            return ResponseEntity.ok(memberService.saveMember(member));
        }
        return ResponseEntity.notFound().build();
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> deleteMember(@PathVariable Integer id) {
        memberService.deleteMember(id);
        return ResponseEntity.noContent().build();
    }

    @GetMapping("/search/name/{name}")
    public ResponseEntity<List<Member>> searchByName(@PathVariable String name) {
        return ResponseEntity.ok(memberService.searchByName(name));
    }

    @GetMapping("/active")
    public ResponseEntity<List<Member>> getActiveMembers() {
        return ResponseEntity.ok(memberService.getActiveMembers());
    }

    @PutMapping("/{id}/deactivate")
    public ResponseEntity<Member> deactivateMember(@PathVariable Integer id) {
        Member member = memberService.deactivateMember(id);
        return member != null ? ResponseEntity.ok(member) : ResponseEntity.notFound().build();
    }
}
