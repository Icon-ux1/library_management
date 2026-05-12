package com.library.service;

import com.library.model.Member;
import com.library.repository.MemberRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.util.List;
import java.util.Optional;

@Service
public class MemberService {
    @Autowired
    private MemberRepository memberRepository;

    public List<Member> getAllMembers() {
        return memberRepository.findAll();
    }

    public Optional<Member> getMemberById(Integer id) {
        return memberRepository.findById(id);
    }

    public Member saveMember(Member member) {
        return memberRepository.save(member);
    }

    public void deleteMember(Integer id) {
        memberRepository.deleteById(id);
    }

    public List<Member> searchByName(String name) {
        return memberRepository.findByNameContainingIgnoreCase(name);
    }

    public Optional<Member> getByMembershipId(String membershipId) {
        return memberRepository.findByMembershipId(membershipId);
    }

    public List<Member> getActiveMembers() {
        return memberRepository.findByIsActive(true);
    }

    public Member deactivateMember(Integer id) {
        Optional<Member> member = memberRepository.findById(id);
        if (member.isPresent()) {
            member.get().setIsActive(false);
            return memberRepository.save(member.get());
        }
        return null;
    }
}
