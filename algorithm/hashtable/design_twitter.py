import heapq

class Twitter(object):
    def __init__(self):
        self.time = 0
        self.tweets = {} #hash between user and corresponding tweets
        self.followee = {} #hash between user and corresponding followee

    def postTweet(self, user, tweet):
        self.time += 1
        currUser = self.tweets.get(user, [])
        print 'currUser', currUser
        self.tweets[user] = currUser + [(-self.time, tweet)]

    def getNewsFeed(self, user):
        h = []
        tweets = self.tweets
        people = self.followee.get(user, set()) | set([user])
        for person in people:
            h.append(tweets[person])



    def follow(self, follower, other):
        self.followee[follower] = self.followee.get(follower, set()) | set([other]) # | for set union and & for intersection

    def unfollow(self, follower, other):
        if follower in self.followee:
            self[followee].discard(other)



# t = Twitter()

# print t.tweets
# print t.followee

# t.postTweet(1, 1)
# t.postTweet(1, 2)
# t.postTweet(1, 3)




# print t.tweets
# print t.followee



# print t.tweets[1][-1]


arr = [1, 30, 20, 9]
heapq.heapify(arr)
heapq.heappush(arr, 5)
heapq.heappop(arr)



# followees = 
# followees[1]


import collections
userId = 1

followees = collections.defaultdict(set)
print followees[1]

followees[1].add(2)
followees[1].add(3)
followees[1].add(4)


tweets = collections.defaultdict(list)
tweets[2].append((0, 997))
tweets[3].append((1, 998))
tweets[4].append((2, 999))

tweets = heapq.merge(*(tweets[u] for u in followees[userId] | {userId}))

print tweets
# print type({1})
# print [type(u for u in [1, 2, 3] + [100])]

# gen = (u for u in [1, 2, 3])

# print gen.next()
# print gen.next()
# print gen.next()
# print gen.next()


# print *(tweets[u] for u in followees[userId] | {userId}) 
